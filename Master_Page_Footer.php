<div class="footer_social">
                    <div style="color: #FFFFFF;">Find us on &nbsp;&nbsp;&nbsp;
                        <a href="https://www.facebook.com/Digitnewsinc/" target="_blank"><i class="ion icon ion-social-facebook"></i></a>
                        <a href="https://twitter.com/DigitNewsinc/" target="_blank"><i class="ion icon ion-social-twitter"></i></a>
                        <a href="https://www.instagram.com/digitnewsinc/" target="_blank"><i class="ion icon ion-social-instagram"></i></a>
                        <a href="http://www.pinterest.com/digitnewsinc/" target="_blank"><i class="ion icon ion-social-pinterest"></i></a>
                        <a href="https://digitnewsinc.tumblr.com/" target="_blank"><i class="ion icon ion-social-tumblr"></i></a>
                    </div>
                </div>
                
            </footer>
        </div>
        <div style="padding-bottom: 20px;"></div>
        <!-- End of page -->
    </main>
    <br /><br />
    <!-- The Modal -->
        <div id="myModal" class="modal">
          <!-- Modal content -->
          <div class="modal-content">
            <span class="close">&times;</span>
            <div class="popupfeeddiv" id="popupfeed_div"></div>
          </div>
        </div>

    <!-- END OF site main content content here -->

    <!-- All Javascript plugins goes here -->
    <script src="js/jquery-1.11.2.min.js"></script>
    <!-- Downcount JS -->
    <!--<script src="js/jquery.downCount.js"></script>-->
    <!-- All vendor scripts -->
    <script src="js/all.js"></script>
    <!-- Form Script -->
    <script src="js/form_script.js"></script>
    <script src="js/ScriptFunctions.js"></script>
    <!-- Javascript main files -->
    <script src="js/main.js"></script>
    <script>
    $(".menu-drawer").click(function () {
        if ($("#mobile_menu").is(":visible"))
        {
            $("#mobile_menu").hide();
            $(".content").css({"margin-left": "2% !important"});
        } else
        {
            $("#mobile_menu").show();
            $(".content").css({"margin-left": "15% !important"});
        }
    });
</script>
</body>

</html>