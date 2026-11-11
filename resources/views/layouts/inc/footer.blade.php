
<footer class="mm-footer">
    <div class="mm-footer-inner">

        {{-- BRAND --}}
        <div class="mm-footer-brand">
            <a href="{{ route('welcome') }}" class="mm-footer-logo">
                <img src="{{ asset('img/leaf1.png') }}" alt="Matcha Mori Logo">
                <span>Matcha Mori</span>
            </a>

            <p class="mm-footer-tagline">
                Your little moment of calm.
            </p>

            <p class="mm-footer-description">
                Discover your favorite matcha drinks, desserts,
                powder, and accessories in one place.
            </p>

            <div class="mm-footer-social">
                <a href="https://instagram.com/ainyyprly" aria-label="Instagram" title="Instagram">
                    <i class="fab fa-instagram"></i>
                </a>

                <a href="https://www.tiktok.com/@ainielea" aria-label="TikTok" title="TikTok">
                    <i class="fab fa-tiktok"></i>
                </a>

                <a href="https://www.facebook.com/matchamori" aria-label="Facebook" title="Facebook">
                    <i class="fab fa-facebook-f"></i>
                </a>

                <a href="https://wa.me/6288902853640" aria-label="WhatsApp" title="WhatsApp">
                    <i class="fab fa-whatsapp"></i>
                </a>

                <a href="https://mail.google.com/mail/?view=cm&fs=1&to=matchamori@email.com" target="_blank" rel="noopener noreferrer" aria-label="Email" title="Email">
                    <i class="far fa-envelope"></i>
                </a>
            </div>

        </div>

       {{-- OTHERS --}}
        <div class="mm-footer-column mm-footer-others">
            <h3>Others</h3>

            <a href="{{ route('welcome') }}#best">Home</a>
            <a href="{{ route('welcome') }}#best">Best Sellers</a>
            <a href="{{ route('about') }}">About Us</a>
            <a href="{{ route('products.index') }}">Menu</a>
        </div>

        {{-- CATEGORIES --}}
        <div class="mm-footer-column">
            <h3>Categories</h3>
            <a href="{{ route('products.index') }}">Matcha Drink</a>
            <a href="{{ route('products.index') }}">Matcha Dessert</a>
            <a href="{{ route('products.index') }}">Matcha Powder</a>
            <a href="{{ route('products.index') }}">Accessories</a>
        </div>

        {{-- CONTACT --}}
        <div class="mm-footer-column mm-footer-contact">
            <h3>Get In Touch</h3>

            <a href="tel:+6217220132" class="mm-footer-contact-item">
                <i class="fas fa-headset"></i>
                <span>+62 1 722 0132</span>
            </a>

            <a href="https://wa.me/6288902853640" class="mm-footer-contact-item">
                <i class="fab fa-whatsapp"></i>
                <span>+62 889-0285-3640 (WhatsApp)</span>
            </a>

            <a href="https://mail.google.com/mail/?view=cm&fs=1&to=matchamori@email.com" target="_blank" rel="noopener noreferrer" class="mm-footer-contact-item">
                <i class="far fa-envelope"></i>
                <span>matchamori@email.com</span>
            </a>

            <div class="mm-footer-contact-item mm-footer-address">
                <i class="far fa-building"></i>
                <div>
                    <strong>Matcha Mori Store</strong>
                    <span>Bobotsari, Purbalingga, Jawa Tengah</span>
                </div>
            </div>
        </div>

    </div>

    {{-- BOTTOM BAR --}}
    <div class="mm-footer-bottom">
        <p>
            &copy; {{ date('Y') }} Matcha Mori.
            All rights reserved.
        </p>

        <span>Made with care for matcha lovers.</span>
    </div>
</footer>
