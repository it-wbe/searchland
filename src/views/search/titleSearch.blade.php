<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="/packages/wbe/searchland/assets/css/searchland.css">

<div class="input-group" id="adv-search" style="float: left; margin: 5px;">
    <input type="text" class="form-control searchGlobal" placeholder="Search..." id="searchGlobal" />
    <div class="input-group-btn">
        <div class="btn-group" role="group">
            <div class="dropdown dropdown-lg">
                <div class="dropdown-menu dropdown-menu-right resultlist" role="menu" id="searchbox">

                </div>
            </div>
            <button type="button" class="btn btn-primary"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
        </div>
    </div>
</div>

<script>
    $(function () {
        var activeButton = 0;
        var timeout;

        $(".searchGlobal").keydown(function (e) {
            if (timeout) {
                clearTimeout(timeout);
            }
            ///// up
            if($(this).val().length > 0)
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
                        $.get("/searchland/" + $('#searchGlobal').val(), function (data) {
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
                        });
                    }
                }, 500);

            }
        });

    });
</script>