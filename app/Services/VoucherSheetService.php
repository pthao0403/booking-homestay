<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class VoucherSheetService
{
    private const SHEET_URL = 'https://docs.google.com/spreadsheets/d/e/2PACX-1vTA6BbwO5PJ98dtrsBHdPDOyOMjp6LaCUmJWhHY2luRh9D-AsnKTGkJmwnFgJgEs8-HhvAZ9oL9lnvR/pub?output=tsv';

    /**
     * @return array<int, array{code:string,discount:string,type:string,status:string}>
     */
    public function all(): array
    {
        $content = $this->fetchSheetContent();

        if ($content === null || trim($content) === '') {
            return [];
        }

        $rows = preg_split("/\r\n|\n|\r/", trim($content)) ?: [];
        $vouchers = [];

        foreach ($rows as $index => $row) {
            if ($index === 0 || trim($row) === '') {
                continue;
            }

            $cols = explode("\t", trim($row));
            $code = $this->cleanCell($cols[0] ?? '');
            $discount = $this->cleanCell($cols[1] ?? '0');
            $type = strtolower($this->cleanCell($cols[2] ?? ''));
            $status = strtolower($this->cleanCell($cols[3] ?? ''));

            if ($code === '') {
                continue;
            }

            $vouchers[] = [
                'code' => strtoupper($code),
                'discount' => $discount,
                'type' => $this->normalizeType($type),
                'status' => $this->normalizeStatus($status),
            ];
        }

        return $vouchers;
    }

    public function findActiveVoucher(string $code): ?array
    {
        $normalizedCode = strtoupper(trim($code));

        foreach ($this->active() as $voucher) {
            if ($voucher['code'] === $normalizedCode) {
                return $voucher;
            }
        }

        return null;
    }

    public function countActive(): int
    {
        return count($this->active());
    }

    public function countExpired(): int
    {
        return count($this->expired());
    }

    /**
     * @return array<int, array{code:string,discount:string,type:string,status:string}>
     */
    public function active(): array
    {
        return array_values(array_filter(
            $this->all(),
            fn (array $voucher): bool => $voucher['status'] === 'active'
        ));
    }

    /**
     * @return array<int, array{code:string,discount:string,type:string,status:string}>
     */
    public function expired(): array
    {
        return array_values(array_filter(
            $this->all(),
            fn (array $voucher): bool => $voucher['status'] === 'expired'
        ));
    }

    public function featured(): ?array
    {
        $active = $this->active();

        return $active[0] ?? null;
    }

    public function formatDiscount(array $voucher): string
    {
        $discount = (float) ($voucher['discount'] ?? 0);
        $type = $voucher['type'] ?? '';

        if ($type === 'percent') {
            return 'Giảm ' . rtrim(rtrim(number_format($discount, 2, '.', ''), '0'), '.') . '%';
        }

        return 'Giảm ' . number_format($discount) . ' VNĐ';
    }

    private function fetchSheetContent(): ?string
    {
        try {
            $response = Http::timeout(10)
                ->accept('text/tab-separated-values')
                ->get(self::SHEET_URL);

            if ($response->successful()) {
                return $response->body();
            }
        } catch (\Throwable $e) {
            // Fall through to file_get_contents fallback below.
        }

        $content = @file_get_contents(self::SHEET_URL);

        return $content === false ? null : $content;
    }

    private function cleanCell(mixed $value): string
    {
        $cleaned = trim((string) $value);

        return preg_replace('/^\xEF\xBB\xBF/', '', $cleaned) ?? $cleaned;
    }

    private function normalizeType(string $type): string
    {
        return match ($type) {
            '%', 'percent', 'percentage', 'phan tram' => 'percent',
            'fixed', 'amount', 'money', 'cash', 'vnd' => 'fixed',
            default => $type,
        };
    }

    private function normalizeStatus(string $status): string
    {
        return match ($status) {
            'active', 'on', 'enabled', 'available', 'hoat dong' => 'active',
            'expired', 'inactive', 'off', 'disabled', 'het han' => 'expired',
            default => $status,
        };
    }
}
