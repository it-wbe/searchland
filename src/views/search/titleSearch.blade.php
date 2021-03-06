<link rel="stylesheet" href="/packages/wbe/searchland/assets/css/searchland.css">
<script>
    $(function () {
        var activeButton = 0;
        var timeout;

        $(".searchGlobal").keydown(function (e) {
            if (timeout) {
                clearTimeout(timeout);
            }
            ///// up
            if($(this).val().length > 1)
                $('.resultlist').show();
            else
                $('.resultlist').hide();

            if (e.which == 38) {
                if (activeButton > 0) {
                    var all = $('.activeSearch').length;
                    var classThis = $('.activeSearch');
                    $(classThis[activeButton]).removeClass('selected');
                    activeButton--;
                    $(classThis[activeButton]).addClass('selected');
                }
            }
            /////enter
            else if (e.which == 13) {
                e.preventDefault();
                var classThis = $('.activeSearch');
                if ($(classThis[activeButton]).find('.linkUrl').attr('href')) {
                    var url = $(classThis[activeButton]).find('.linkUrl').attr('href');
                    window.location.href = url;
                }

                ///////down
            } else if (e.which == 40) {
                var all = $('.activeSearch').length;

                if ($('.activeSearch').length > 0 && activeButton < all - 1) {
                    var classThis = $('.activeSearch');
                    $(classThis[activeButton]).removeClass('selected');
                    activeButton++;
                    $(classThis[activeButton]).addClass('selected');
                }
                /////search
            } else {
                activeButton = 0;
                timeout = setTimeout(function () {
                    if ($(".searchGlobal").val().length > 0) {
                        $.post("/searchland" ,{
                            "_token": "{{ csrf_token() }}",
                            "search":$('#searchGlobal').val()
                        }, function (data) {
                            var aa="";
                            data = JSON.parse(data);
                            var template = $('#template');
//                             url_field_name = data['urlname'];
//                            data_col = data['datacol'];
                            $(data['data']).each(function(index,val){
                                @if(View::exists('search.template'))
                                    aa += @include('search.template')
                                @else
                                    aa += @include('searchland::search.template')
                                @endif

                           });
                            $("#searchbox").html(aa);
							$("#searchbox> .activeSearch").first().addClass('selected');
							$("#searchbox").show();
                        });
                    }
                }, 500);

            }
        });

    });
</script>