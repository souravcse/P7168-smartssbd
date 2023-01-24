<?php


namespace App\manages;



class TemplateHeader
{
    function getHtml()
    {
        return "
            <header id=\"page-topbar\">
                <div class=\"layout-width\">
                    <div class=\"navbar-header\">
                        <div class=\"d-flex\">
                            <!-- LOGO -->
                        </div>
        
                        <div class=\"d-flex align-items-center\">
        
                            <div class=\"dropdown ms-sm-3 header-item topbar-user\">
                                <button type=\"button\" class=\"btn\" id=\"page-header-user-dropdown\" data-bs-toggle=\"dropdown\"
                                        aria-haspopup=\"true\" aria-expanded=\"false\">
                                            <span class=\"d-flex align-items-center\">
                                                <img class=\"rounded-circle header-profile-user\"
                                                     src=\"/assets/template-admin/images/users/avatar-1.jpg\" alt=\"Header Avatar\">
                                                <span class=\"text-start ms-xl-2\">
                                                    <span class=\"d-none d-xl-inline-block ms-1 fw-medium user-name-text\">Edward Diana</span>
                                                </span>
                                            </span>
                                </button>
                                <div class=\"dropdown-menu dropdown-menu-end\">
                                    <!-- item-->
                                    <h6 class=\"dropdown-header\">Welcome Diana!</h6>
                                    <a class=\"dropdown-item\" href=\"pages-profile.html\"><i
                                                class=\"mdi mdi-account-circle text-muted fs-16 align-middle me-1\"></i> <span
                                                class=\"align-middle\">Profile</span></a>
                                    <a class=\"dropdown-item\" href=\"pages-profile-settings.html\"><i
                                                class=\"mdi mdi-cog-outline text-muted fs-16 align-middle me-1\"></i> <span
                                                class=\"align-middle\">Settings</span></a>
                                    <a class=\"dropdown-item\" href=\"auth-logout-basic.html\"><i
                                                class=\"mdi mdi-logout text-muted fs-16 align-middle me-1\"></i> <span
                                                class=\"align-middle\" data-key=\"t-logout\">Logout</span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
           ";
    }
}