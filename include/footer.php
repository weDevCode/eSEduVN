<?php 
    /*============================
        eSEduVN (e-systemEduVN)
        Made with love by Tien Minh Vy
    ============================*/
    if(!defined('isSet')){
        die('<h1>Direct access is not allowed!</h1>');
    }
?>    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <script defer src="https://friconix.com/cdn/friconix.js"> </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script>
        $(document).ready(function(){
            
            // Ghi nhớ người dùng đã bật/tắt menu chưa

            $("#dslopToggle").click(function(){
                $("#dslop ul").slideToggle("slow");
                
                if (click==1) {
                    document.cookie = "ktraDsLop=true";
                    click=2;
                } else {
                    document.cookie = "ktraDsLop=false";
                    click=1;
                }
            });

            function getCookieValue(a) {
                var b = document.cookie.match('(^|;)s*' + a + 's*=s*([^;]+)');
                return b ? b.pop() : '';
            }

            if (getCookieValue('ktraDsLop')=='true') {
                click = 2;
                $("#dslop ul").slideDown("fast");
            } else if (getCookieValue('ktraDsLop')=='false') {
                $("#dslop ul").slideUp("fast");

                click = 1;
            } else {
                $("#dslop ul").slideUp("fast");
                document.cookie = "ktraDsLop=false";
                click = 1;
            }
        });
    </script>
</body>
</html>