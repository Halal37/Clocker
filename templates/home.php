<?php $title = 'Clocker' ?>

<?php ob_start() ?>
    <div id="app-description">
        <img src="https://c.pxhere.com/images/af/aa/ad86cc1ba66dce75a8c1d8dc2234-1640636.jpg!d" id="desc-img" alt="obrazek-mierzenia-czasu">
        <p id="desc">Croissant danish ice cream jelly cake. Wafer halvah gummies cake pie. Candy canes apple pie
            cupcake donut cake biscuit cake tiramisu chupa chups. Jelly-o candy canes cake jelly beans cookie
            topping tart tart halvah. Halvah shortbread lemon drops macaroon caramels chocolate bonbon marzipan
            dragée. Oat cake caramels jelly-o sweet toffee. Shortbread candy canes toffee jelly beans soufflé
            fruitcake cake candy cookie. Bonbon brownie dessert pudding sweet sweet roll. Pudding cookie marshmallow
            tiramisu cookie dessert donut danish.</p>
    </div>
    <div id="user-stats">
        <h2>Statystyki użytkowników</h2>
        <div id="user-stats-content">
            Zobacz jak nasi użytkownicy korzystają z clockera!
            Jest już z nami <i id="users-number">2303</i> użytkowników!
        </div>

        <div id="user-stats-main-container">
            <div class="user-stat-container">
                <div class="user-stat">
                    <p id="week-stat" class="stat-title">100 h</p>
                    <p class="stat-desc">w tym tygodniu</p>
                </div>
            </div>

            <div class="user-stat-container">
                <div class="user-stat">
                    <p id="month-stat" class="stat-title">1 000 h</p>
                    <p class="stat-desc">w tym miesiącu</p>
                </div>
            </div>

            <div class="user-stat-container">
                <div class="user-stat">
                    <p id="year-stat" class="stat-title">10 000 h</p>
                    <p class="stat-desc">w tym roku</p>
                </div>
            </div>

            <div class="user-stat-container">
                <div class="user-stat">
                    <p id="all-stat" class="stat-title">100 000 h</p>
                    <p class="stat-desc">od początku</p>
                </div>
            </div>
        </div>
    </div>

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

<script src="../scripts/cookie-alert.js"></script>
<?php $content = ob_get_clean() ?>

<?php include 'landingPageLayout.php' ?>