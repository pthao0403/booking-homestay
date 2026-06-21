# TODO

## Step 1: Identify why test@example.com can’t access admin
- [x] Read AdminAuthController: admin dashboard is gated by `Auth::user()->role === 'admin'`
- [x] Read UserFactory + DatabaseSeeder: DatabaseSeeder creates test@example.com but **does not set role**, so role may not be `admin`
- [x] Confirm UserFactory default `role` is not set (only name/email/password/email_verified_at/remember_token)

## Step 2: Fix admin seeding
- [ ] Update `database/seeders/DatabaseSeeder.php` to create an admin user with:
  - email: test@example.com
  - password: password
  - role: admin

## Step 3: Verify
- [ ] Run migrations + seed
- [ ] Login with /admin/login using test@example.com / password
- [ ] Confirm redirect to /admin/dashboard

