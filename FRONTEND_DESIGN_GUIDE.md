# Frontend Design Guide - Room Listing & Details

## 📋 Tổng Quan
Thiết kế giao diện hiện đại cho hệ thống đặt phòng homestay với 2 trang chính:
1. **Danh Sách Phòng** (Room List)
2. **Chi Tiết Phòng** (Room Details)

---

## 🎨 Danh Sách Phòng (`resources/views/rooms/index.blade.php`)

### Các Phần Chính:

#### 1️⃣ **Header Section (Hero)**
```
- Gradient background (Purple → Green)
- Tiêu đề lớn: "Khám Phá Những Phòng Xinh Đẹp"
- Phụ đề: "Tìm kiếm và đặt phòng homestay yêu thích của bạn"
- Padding: 4rem, Margin-bottom: 3rem
```

#### 2️⃣ **Filter Section**
```
- Card trắng với shadow nhẹ
- Grid layout: 4 cột (Tìm kiếm, Ngày nhận, Ngày trả, Nút tìm)
- Căn chỉnh: align-items flex-end (nút thẳng hàng)
- Responsive: Trên mobile là 1 cột
```

**Các trường:**
- Tìm kiếm: Text input (placeholder: "Tên phòng, địa chỉ...")
- Ngày nhận phòng: Date input
- Ngày trả phòng: Date input
- Nút Tìm kiếm: Primary button
- Nút Xóa lọc: Secondary button (hiển thị nếu có filter)

#### 3️⃣ **Results Info**
```
- Hiển thị số lượng phòng tìm được
- Margin-bottom: 2rem
- Color: #6b7280
```

#### 4️⃣ **Room Grid**
```
- Grid layout: 3 cột (300px min-width)
- Gap: 2rem
- Responsive:
  - Desktop: 3 cột
  - Tablet: 2 cột
  - Mobile: 1 cột
```

**Thành phần Room Card:**

| Phần | Mô tả |
|------|-------|
| **Image** | 240px height, hover zoom 1.05 |
| **Badge** | Room type, abs pos top-right |
| **Title** | 1.25rem, font-weight 700 |
| **Location** | Với icon geo-alt (red) |
| **Features** | Icon + capacity |
| **Description** | Truncate 80 chars |
| **Footer** | Price + "Chi Tiết" button |

**Hover Effects:**
- Card: translateY(-8px), shadow tăng
- Image: scale(1.05)

#### 5️⃣ **Empty State**
```
- Khi không có phòng
- Icon inbox lớn
- Message: "Không tìm thấy phòng nào phù hợp"
- Link "Xem tất cả phòng"
```

#### 6️⃣ **Pagination**
```
- Căn giữa
- Rounded corners
- Active page: Indigo background
- Hover: Color change
```

---

## 🏨 Chi Tiết Phòng (`resources/views/rooms/show.blade.php`)

### Các Phần Chính:

#### 1️⃣ **Hero Section**
```
- Gradient background (Purple → Green)
- Back link: "Quay lại danh sách"
- Room name (2.5rem, font-weight 700)
- Location (1.1rem)
- Price display: "VNĐ/đêm"
- Layout: Flex, space-between
```

#### 2️⃣ **Main Content + Sidebar Layout**
```
CSS Grid:
- Cột 1: Main content (flex: 1)
- Cột 2: Sidebar (350px, sticky)

Gap: 2rem

Responsive:
- Desktop: 2 cột
- Tablet/Mobile: 1 cột (stacked)
```

#### 3️⃣ **Main Image**
```
- Full width
- Max-height: 600px
- object-fit: cover
- Border-radius: 12px
- Box-shadow: 0 10px 30px
```

#### 4️⃣ **Gallery Section**
```
- Title: "Thư Viện Ảnh"
- Grid: repeat(auto-fill, minmax(200px, 1fr))
- Gap: 1rem
- Hover: scale(1.05) + shadow

CSS:
- aspect-ratio: 1 (square images)
- object-fit: cover
```

#### 5️⃣ **Info Section (Thông Tin Chi Tiết)**
```
- Heading: "Thông Tin Chi Tiết" + icon info-circle
- Description paragraph
- Background: white, padding: 2rem
- Border-radius: 12px
- Box-shadow nhẹ
```

#### 6️⃣ **Features Section**
```
- 3 Feature Cards (Capacity, Type, Status)
- Grid: repeat(auto-fit, minmax(200px, 1fr))
- Mỗi card:
  - Icon circle (60px) với gradient
  - Heading
  - Value (large, bold)

Gradients:
- Capacity: Purple → Purple-darker
- Type: Green → Green-darker
- Status: Amber → Amber-darker
```

#### 7️⃣ **Amenities Section**
```
- Title: "Tiện Nghi" + icon check-lg
- Grid: repeat(auto-fit, minmax(150px, 1fr))
- Mỗi item:
  - Icon (left)
  - Text (right)
  - Background: #f3f4f6
  - Padding: 1rem
  - Border-radius: 8px

Icons: WiFi, Lock, Cup, TV, Droplet, Wind
```

#### 8️⃣ **Map Section**
```
- Title: "Vị Trí" + icon map
- Placeholder (Gradient background)
- Text: "Bản đồ vị trí sẽ hiển thị tại đây"
- Small: "Google Maps sẽ được tích hợp sớm"
```

#### 9️⃣ **Sidebar - Booking Card**
```
Sections:
1. Price display (centered, bottom border)
2. Status alert (green/red)
3. Quick info (background: #f3f4f6)
4. Buttons (grid, 2 rows)
5. Policies (top border, italic)

Sticky position: top 100px
```

**Buttons:**
- Đặt Phòng: Primary gradient (full width)
- Yêu Thích: Outline style
- Both: Full width

**Policies:**
- Hủy miễn phí 24h
- Thanh toán trực tuyến/khi nhận

#### 🔟 **Contact Card**
```
- Background: #f0f4ff
- Border-left: 4px #6366f1
- Title: "Có câu hỏi?"
- Description
- Button: "Chat với chủ nhà"
```

---

## 🎨 Design System

### Colors
```
Primary:    #6366f1 (Indigo)
Secondary:  #10b981 (Green)
Danger:     #ef4444 (Red)
Warning:    #f59e0b (Amber)
Light BG:   #f9fafb (Light Gray)
Dark Text:  #1f2937 (Dark Gray)
Border:     #d1d5db (Light Border)
```

### Typography
```
Font Family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif

Headings:
- H1: 2.5rem, font-weight 700
- H2: 1.5rem, font-weight 700
- H3: 1.25rem, font-weight 700

Body: 1rem, line-height 1.6
```

### Spacing
```
Base unit: 0.5rem

Common:
- Padding: 1rem, 1.5rem, 2rem
- Margin: 1rem, 1.5rem, 2rem
- Gap: 1rem, 1.5rem, 2rem
```

### Border Radius
```
Small:  8px
Medium: 12px
Large:  20px (badges)
```

### Shadows
```
Light:   0 1px 3px rgba(0, 0, 0, 0.05)
Medium:  0 4px 20px rgba(0, 0, 0, 0.1)
Heavy:   0 10px 30px rgba(0, 0, 0, 0.15)
```

---

## 📱 Responsive Breakpoints

### Desktop (1024px+)
- Rooms grid: 3 cột
- Detail: 2 cột (content + sidebar)
- Sidebar: Sticky

### Tablet (768px - 1023px)
- Rooms grid: 2 cột
- Detail: Full width (sidebar dưới)
- Sidebar: Not sticky

### Mobile (< 768px)
- Rooms grid: 1 cột
- Detail: 1 cột
- Smaller font sizes
- Adjusted padding

---

## 🎯 Animations & Interactions

### Hover Effects

**Room Cards:**
```css
.room-card:hover {
  transform: translateY(-8px);
  box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
}
```

**Images:**
```css
.room-image:hover {
  transform: scale(1.05);
}
```

**Buttons:**
```css
.btn-primary:hover {
  transform: translateY(-3px);
  box-shadow: 0 6px 20px rgba(99, 102, 241, 0.4);
}
```

**Gallery Items:**
```css
.gallery-item:hover {
  transform: scale(1.05);
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
}
```

### Transitions
- Duration: 0.3s
- Timing: Linear
- Properties: transform, box-shadow, color, background

---

## 🔗 Links & Navigation

- **Danh sách phòng:** `/rooms`
- **Chi tiết phòng:** `/rooms/{id}`
- **Đặt phòng:** `/rooms/{id}/booking`

---

## ✅ Checklist

- [x] Modern gradient headers
- [x] Responsive grid layouts
- [x] Beautiful room cards
- [x] Feature cards with gradient
- [x] Sticky sidebar (detail page)
- [x] Amenities grid
- [x] Gallery section
- [x] Contact card
- [x] Hover animations
- [x] Mobile optimization
- [x] Accessibility icons

---

## 🚀 Tiếp Theo

### Sắp tới:
1. **Tích hợp Google Maps API** - Hiển thị vị trí phòng
2. **Google Places API** - Gợi ý địa chỉ
3. **Google Geocoding API** - Chuyển địa chỉ → tọa độ
4. **Lightbox/Modal** - Xem ảnh phóng to
5. **Reviews section** - Đánh giá từ khách hàng
6. **Wishlist** - Lưu phòng yêu thích
7. **Calendar** - Hiển thị ngày trống
8. **Real-time availability** - Kiểm tra live

---

## 📝 Notes

- Tất cả styles được inline hoặc trong `<style>` tag
- Có thể move sang CSS file riêng sau
- Component gallery có script riêng (xem gallery.blade.php)
- Bootstrap icons được sử dụng (bi-*)
- Chưa tích hợp JavaScript (sẽ thêm sau)

