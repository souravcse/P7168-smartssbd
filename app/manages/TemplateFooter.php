<?php

namespace App\manages;

class TemplateFooter
{
    function getHtml(){
        return "
                <footer class=\"footer\">
            <div class=\"container-fluid\">
                <div class=\"row\">
                    <div class=\"col-sm-6\">
                        <script>document.write(new Date().getFullYear())</script>
                        © Smart Solution For Software.
                    </div>
                    <div class=\"col-sm-6\">
                        <div class=\"text-sm-end d-none d-sm-block\">
                        </div>
                    </div>
                </div>
            </div>
        </footer>

        ";
    }
}