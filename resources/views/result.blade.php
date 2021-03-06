
<!DOCTYPE html >
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=emulateIE7" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Prikango搜索引擎</title>
<link href="/css/style.css" rel="stylesheet" type="text/css" />
<link href="/css/result.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="container">
	<div id="hd" class="ue-clear">
    	<a href="/home"><div class="logo"></div></a>
        <div class="inputArea">
        	<input type="text" class="searchInput" name="keyWords" value="{{ $key_words }}"/>
            <input type="button" class="searchButton" onclick="add_search()"/>
            @if(session()->has('message'))
                <div style="color:red;">
                    {{ session()->get('message') }}
                </div>
            @endif
        </div>
    </div>
    <div class="nav">
    	<ul class="searchList">
        </ul>
    </div>
	<div id="bd" class="ue-clear">
        <div id="main">
        	<div class="sideBar">
                <div class="subfield">作者</div>
                <ul class="subfieldContext">
                    <li>
                        <a href="https://github.com/paprikaLang" class="name">GitHub</a>
                    </li>
                    <li>
                        <a href="https://twitter.com/paprikaLang" class="name">Twitter</a>
                    </li>
                    <li>
                        <a href="https://paprikalang.github.io" class="name">Blog</a>
                    </li>
                </ul>
                <div class="sideBarShowHide">
                	<a href="javascript:;" class="icon"></a>
                </div>
            </div>
            <div class="resultArea">
            	<p class="resultTotal">
                	<span class="info">找到约&nbsp;<span class="totalResult">{{ $total_nums }}</span>&nbsp;条结果，共约<span class="totalPage">{{ $page_nums }}</span>页</span>
                </p>
                <div class="resultList">
                    @foreach($all_hits as $hit)
                    <div class="resultItem">
                            <div class="itemHead">
                                <a href="{{ $hit['url'] }}" style="text-decoration:none;"  target="_blank" class="title">{!!  $hit['title'] !!}</a>
                                <span class="divsion">-</span>
                                <span class="fileType">
                                    <span class="label">来源：</span>
                                    <span class="value">{{ $s_type }}</span>
                                </span>
                                <span class="dependValue">
                                    <span class="label">得分：</span>
                                    <span class="value">{{ $hit['score'] }}</span>
                                </span>
                            </div>
                            <div class="itemBody">
                                {!! $hit['content'] !!}
                            </div>
                            <div class="itemFoot" style="margin-bottom: 30px;">
                                <span class="info">
                                    <label>网站：</label>
                                    <span class="value">{{ $s_type }}</span>
                                </span>
                                <span class="info">
                                    <label>发布时间：</label>
                                    <span class="value">{{ $hit['create_date'] }}</span>
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
                <!-- 分页 -->
                <div class="pagination ue-clear"></div>
                <!-- 相关搜索 -->
            </div>
        </div><!-- End of main -->
    </div><!--End of bd-->
</div>
</body>
<script type="text/javascript" src="/js/jquery.js"></script>
<script type="text/javascript" src="/js/global.js"></script>
<script type="text/javascript" src="/js/pagination.js"></script>
<script type="text/javascript">

    var s_type = "{{ $s_type }}"
	$('.searchList').on('click', '.searchItem', function(){
        if (s_type === 'article') {
            s_type = 'job'
        }else {
            s_type = 'article'
        }
		$('.searchList .searchItem').removeClass('current');
		$(this).addClass('current');
		add_search()
	});
	
	$.each($('.subfieldContext'), function(i, item){
		$(this).find('li:gt(2)').hide().end().find('li:last').show();		
	});

	$('.subfieldContext .more').click(function(e){
		var $more = $(this).parent('.subfieldContext').find('.more');
		if($more.hasClass('show')){
			
			if($(this).hasClass('define')){
				$(this).parent('.subfieldContext').find('.more').removeClass('show').find('.text').text('自定义');
			}else{
				$(this).parent('.subfieldContext').find('.more').removeClass('show').find('.text').text('更多');	
			}
			$(this).parent('.subfieldContext').find('li:gt(2)').hide().end().find('li:last').show();
	    }else{
			$(this).parent('.subfieldContext').find('.more').addClass('show').find('.text').text('收起');
			$(this).parent('.subfieldContext').find('li:gt(2)').show();	
		}
		
	});
	
	$('.sideBarShowHide a').click(function(e) {
		if($('#main').hasClass('sideBarHide')){
			$('#main').removeClass('sideBarHide');
			$('#container').removeClass('sideBarHide');
		}else{
			$('#main').addClass('sideBarHide');	
			$('#container').addClass('sideBarHide');
		}
        
    });
    var key_words = $("input[name='keyWords']").val()
	//分页
    var per_page = 10
	$(".pagination").pagination({{ $total_nums }}, {
		current_page :{{$page - 1}}, //当前页码
		items_per_page :per_page,
		display_msg :true,
		callback :(page_id, jq) => {
            page_id += 1
            window.location.href='search?q='+key_words+'&p='+page_id+'&s_type='+s_type
        }
	});

	$(window).resize(function(){
		setHeight();	
	});
	
	function setHeight(){
		if($('#container').outerHeight() < $(window).height()){
			$('#container').height($(window).height()-33);
		}	
	}
</script>
<script type="text/javascript">
    $('.searchList').on('click', '.searchItem', function(){

        $('.searchList .searchItem').removeClass('current');
        $(this).addClass('current');
        add_search()

    });

    $('.searchInput').on('focus', function(){
        $('.dataList').show()
    });

    $('.dataList').on('click', 'li', function(){
        var text = $(this).text();
        $('.searchInput').val(text);
        $('.dataList').hide()
    });

    hideElement($('.dataList'), $('.searchInput'));
</script>
<script>
    function add_search(){
        var val = $(".searchInput").val();
        window.location.href='search?q='+val+"&s_type=article&p=1"

    }
</script>
</html>