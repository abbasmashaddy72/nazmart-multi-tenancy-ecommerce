 <footer class="footer-area theme-three-footer-border {{'footer-'.getSelectedThemeSlug()}}">
     <div class="footer-top padding-top-35 padding-bottom-90">
         <div class="container container-one">
             <div class="row justify-content-between">
                 {!! render_frontend_sidebar('footer',['column' => true]) !!}
             </div>
         </div>
     </div>
 </footer>

<footer class="footer-area footer-bg">
    <div class="footer-top-area footer-top-border padding-top-45 padding-bottom-70">
        <div class="container custom-container-one">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6 col-sm-6 mt-4">
                    <div class="footer-widget widget">
                        <div class="footer-inner">
                            <div class="about_us_widget">
                                <a href="index.html" class="footer-logo"> <img src="assets/img/logo_footer.png" alt="footer logo"></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 mt-4">
                    <div class="footer-widget widget">
                        <div class="footer-inner">
                            <div class="footer-menu">
                                <ul class="payment-list">
                                    <li class="list">
                                        <a href="javascript:void(0)"> <img src="assets/img/footer/payment1.png" alt=""> </a>
                                    </li>
                                    <li class="list">
                                        <a href="javascript:void(0)"> <img src="assets/img/footer/payment2.png" alt=""> </a>
                                    </li>
                                    <li class="list">
                                        <a href="javascript:void(0)"> <img src="assets/img/footer/payment3.png" alt=""> </a>
                                    </li>
                                    <li class="list">
                                        <a href="javascript:void(0)"> <img src="assets/img/footer/payment4.png" alt=""> </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-middler padding-top-45 padding-bottom-70">
        <div class="container custom-container-one">
            <div class="row justify-content-between">
                {!! render_frontend_sidebar('footer',['column' => true]) !!}
            </div>
        </div>
    </div>
    <div class="copyright-area copyright-border">
        <div class="container container-three">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="col-lg-12">
                        <div class="copyright-contents center-text">
                            {!! get_footer_copyright_text() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
