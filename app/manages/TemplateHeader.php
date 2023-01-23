<?php


namespace App\manages;



class TemplateHeader
{
    function getHtml()
    {
        return "
         <div class=\"top-tagbar\">
        <div class=\"w-100\">
            <div class=\"row justify-content-between align-items-center\">
                <div class=\"col-md-4 col-9\">
                    <div class=\"text-white-50 fs-13\">
                        <i class=\"bi bi-clock align-middle me-2\"></i> <span id=\"current-time\"></span>
                    </div>
                </div>
                <div class=\"col-md-4 col-6 d-none d-lg-block\">
                    <div class=\"d-flex align-items-center justify-content-center gap-3 fs-13 text-white-50\">
                        <div>
                            <i class=\"bi bi-envelope align-middle me-2\"></i> support@themesbrand.com
                        </div>
                        <div>
                            <i class=\"bi bi-globe align-middle me-2\"></i> www.themesbrand.com
                        </div>
                    </div>
                </div>
                <div class=\"col-md-4 col-3\">
                    <div class=\"dropdown topbar-head-dropdown topbar-tag-dropdown justify-content-end\">
                        <button type=\"button\" class=\"btn btn-icon btn-topbar rounded-circle text-white-50 fs-13\"
                                data-bs-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
                            <img id=\"header-lang-img\" src=\"/assets/template-admin/images/flags/us.svg\"
                                 alt=\"Header Language\" height=\"16\"
                                 class=\"rounded-circle me-2\"> <span id=\"lang-name\">English</span>
                        </button>
                        <div class=\"dropdown-menu dropdown-menu-end\">

                            <!-- item-->
                            <a href=\"javascript:void(0);\" class=\"dropdown-item notify-item language py-2\" data-lang=\"en\"
                               title=\"English\">
                                <img src=\"/assets/template-admin/images/flags/us.svg\" alt=\"user-image\"
                                     class=\"me-2 rounded-circle\"
                                     height=\"18\">
                                <span class=\"align-middle\">English</span>
                            </a>

                            <!-- item-->
                            <a href=\"javascript:void(0);\" class=\"dropdown-item notify-item language\" data-lang=\"sp\"
                               title=\"Spanish\">
                                <img src=\"/assets/template-admin/images/flags/spain.svg\" alt=\"user-image\"
                                     class=\"me-2 rounded-circle\"
                                     height=\"18\">
                                <span class=\"align-middle\">Española</span>
                            </a>

                            <!-- item-->
                            <a href=\"javascript:void(0);\" class=\"dropdown-item notify-item language\" data-lang=\"gr\"
                               title=\"German\">
                                <img src=\"/assets/template-admin/images/flags/germany.svg\" alt=\"user-image\"
                                     class=\"me-2 rounded-circle\"
                                     height=\"18\"> <span class=\"align-middle\">Deutsche</span>
                            </a>

                            <!-- item-->
                            <a href=\"javascript:void(0);\" class=\"dropdown-item notify-item language\" data-lang=\"it\"
                               title=\"Italian\">
                                <img src=\"/assets/template-admin/images/flags/italy.svg\" alt=\"user-image\"
                                     class=\"me-2 rounded-circle\"
                                     height=\"18\">
                                <span class=\"align-middle\">Italiana</span>
                            </a>

                            <!-- item-->
                            <a href=\"javascript:void(0);\" class=\"dropdown-item notify-item language\" data-lang=\"ru\"
                               title=\"Russian\">
                                <img src=\"/assets/template-admin/images/flags/russia.svg\" alt=\"user-image\"
                                     class=\"me-2 rounded-circle\"
                                     height=\"18\">
                                <span class=\"align-middle\">русский</span>
                            </a>

                            <!-- item-->
                            <a href=\"javascript:void(0);\" class=\"dropdown-item notify-item language\" data-lang=\"ch\"
                               title=\"Chinese\">
                                <img src=\"/assets/template-admin/images/flags/china.svg\" alt=\"user-image\"
                                     class=\"me-2 rounded-circle\"
                                     height=\"18\">
                                <span class=\"align-middle\">中国人</span>
                            </a>

                            <!-- item-->
                            <a href=\"javascript:void(0);\" class=\"dropdown-item notify-item language\" data-lang=\"fr\"
                               title=\"French\">
                                <img src=\"/assets/template-admin/images/flags/french.svg\" alt=\"user-image\"
                                     class=\"me-2 rounded-circle\"
                                     height=\"18\">
                                <span class=\"align-middle\">français</span>
                            </a>

                            <!-- item-->
                            <a href=\"javascript:void(0);\" class=\"dropdown-item notify-item language\" data-lang=\"ar\"
                               title=\"Arabic\">
                                <img src=\"/assets/template-admin/images/flags/ae.svg\" alt=\"user-image\"
                                     class=\"me-2 rounded-circle\"
                                     height=\"18\">
                                <span class=\"align-middle\">عربى</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
                                            <span class=\"d-none d-xl-block ms-1 fs-13 text-muted user-name-sub-text\">Founder</span>
                                        </span>
                                    </span>
                        </button>
                        <div class=\"dropdown-menu dropdown-menu-end\">
                            <!-- item-->
                            <h6 class=\"dropdown-header\">Welcome Diana!</h6>
                            <a class=\"dropdown-item\" href=\"pages-profile.html\"><i
                                        class=\"mdi mdi-account-circle text-muted fs-16 align-middle me-1\"></i> <span
                                        class=\"align-middle\">Profile</span></a>
                            <a class=\"dropdown-item\" href=\"#!\"><i
                                        class=\"mdi mdi-message-text-outline text-muted fs-16 align-middle me-1\"></i>
                                <span
                                        class=\"align-middle\">Messages</span></a>
                            <a class=\"dropdown-item\" href=\"#!\"><i
                                        class=\"mdi mdi-calendar-check-outline text-muted fs-16 align-middle me-1\"></i>
                                <span
                                        class=\"align-middle\">Taskboard</span></a>
                            <a class=\"dropdown-item\" href=\"pages-faqs.html\"><i
                                        class=\"mdi mdi-lifebuoy text-muted fs-16 align-middle me-1\"></i> <span
                                        class=\"align-middle\">Help</span></a>
                            <div class=\"dropdown-divider\"></div>
                            <a class=\"dropdown-item\" href=\"pages-profile.html\"><i
                                        class=\"mdi mdi-wallet text-muted fs-16 align-middle me-1\"></i> <span
                                        class=\"align-middle\">Balance : <b>$8451.36</b></span></a>
                            <a class=\"dropdown-item\" href=\"pages-profile-settings.html\"><span
                                        class=\"badge bg-soft-success text-success mt-1 float-end\">New</span><i
                                        class=\"mdi mdi-cog-outline text-muted fs-16 align-middle me-1\"></i> <span
                                        class=\"align-middle\">Settings</span></a>
                            <a class=\"dropdown-item\" href=\"auth-lockscreen-basic.html\"><i
                                        class=\"mdi mdi-lock text-muted fs-16 align-middle me-1\"></i> <span
                                        class=\"align-middle\">Lock screen</span></a>
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