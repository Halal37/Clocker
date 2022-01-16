<?php $title = 'Clocker' ?>

<?php ob_start() ?>

<main class="raport-main">
<p>Wygenerowano pomyślnie raport</p>
<i class="bi-check2"></i>
    </main>
<div id="cookie-alert">
    <div id="cookie-content">
        <!--            <b>Do you like cookies?</b> &#x1F36A; We use cookies to ensure you get the best experience on our website.-->
        <b>Lubisz ciasteczka?</b> &#x1F36A; Używamy ciasteczek aby zapewnić Tobie jak najlepsze wrażenia z korzystania z naszego serwisu.
        <a href="https://cookiesandyou.com/" target="_blank">Dowiedz się więcej</a>
    </div>
    <div id="cookie-button">
        <button type="button" id="accept-cookies-btn">
            Zgadzam się
        </button>
    </div>
</div>

<script src="../cookie-alert.js"></script>
<?php $content = ob_get_clean() ?>

<?php include 'additionalLayout.php' ?>