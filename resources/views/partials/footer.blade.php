<footer class="footer">
    <div class="footer-container">
        <div class="footer-section">
            <h3>About Us</h3>
            <p>Your trusted platform for booking comfortable homestays.</p>
        </div>
        
        <div class="footer-section">
            <h3>Quick Links</h3>
            <ul>
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('rooms.index') }}">Browse Rooms</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
        </div>
        
        <div class="footer-section">
            <h3>Contact</h3>
            <p>Email: info@bookinghomestay.com</p>
            <p>Phone: +1 (555) 123-4567</p>
        </div>
    </div>
    
    <div class="footer-bottom">
        <p>&copy; {{ now()->year }} Booking Homestay. All rights reserved.</p>
    </div>
</footer>
