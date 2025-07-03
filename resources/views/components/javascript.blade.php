<script type="text/javascript">
    $(document).ready(function () {

        /////////////////////////
        ////////////////////////
        // this is for the search bar animation
        $("#searchbar").hide();
        $("#searchbar").animate({width: '0'}, 0);
        $("#searchbar").removeClass("hidden");

        $("#search_glass").click(function () {

            if ($("#searchbar").is(":hidden")) {
                console.log("search was hidden");
                $("#searchbar").show();
                $('#search_glass').addClass("border-gray-300 text-gray-700")
                $("#searchbar").animate({width: '100%'}, 500, function () {

                    $(this).focus();
                    $('#search_ul').slideDown();
                });
            } else {
                console.log("search was visible");
                $('#search_glass').removeClass("border-gray-300 text-gray-700");
                $("#searchbar").animate({width: '0'}, 500, function () {
                    //$("#searchbar").val("");
                    $(this).hide();
                    $('#search_ul').slideUp();
                    $("#searchbar").trigger('change');

                });
            }

        });
        //// end of search bar javascript code
        ////////////////////////////
        //////////////////////////


    });

</script>
