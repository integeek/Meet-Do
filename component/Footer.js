function Footer(url) {
        return `
        <div>
            <ul class="footer-links">
                <li><a href="FAQ">FAQ</a></li>
                <li><a href="#">Nous contacter</a></li>
                <li><a href="#">Mentions légales</a></li>
                <li><a href="#">Forum</a></li>
            </ul>
        </div>
        <div class="footer-social-container">
            <a href="https://www.linkedin.com/"><img src="${url}/assets/img/linkedin-icon.png" alt="linkedin" class="footer-social"></a>
            <a href="https://www.facebook.com/"><img src="${url}/assets/img/facebook-icon.png" alt="facebook" class="footer-social"></a>
            <a href="https://www.twitter.com/"><img src="${url}/assets/img/x-icon.png" alt="twitter" class="footer-social"></a>
            <a href="https://www.instagram.com/"><img src="${url}/assets/img/instagram-icon.png" alt="instagram" class="footer-social"></a>
        </div>
    `;
};