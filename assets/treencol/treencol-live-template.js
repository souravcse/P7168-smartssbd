(function ($) {
    $.fn.liveTemplate = function (templateId, fnOnLoad) {
        let $this = $(this);

        let $template = $(live_template_html[templateId]);
        $this.html(live_template_html[templateId]);
        fnOnLoad($template);

        return false;
    };
})(jQuery);

function urlGenerator(route, valJson) {
    $.each(valJson, function (key, val) {
        route = route.replace("{" + key + "}", val);
    });
    return "/" + route + "/";
}