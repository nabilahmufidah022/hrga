$(document).ready(function () {
    // Add loading states
    $(".btn[data-request]").on("click", function () {
        $(this).addClass("loading");
    });

    // Enhanced row selection
    $(".table-data tbody tr").on("click", function (e) {
        if (!$(e.target).is("input, a, button")) {
            const checkbox = $(this).find('input[type="checkbox"]');
            checkbox
                .prop("checked", !checkbox.prop("checked"))
                .trigger("change");
        }
    });
});
