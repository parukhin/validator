var st = '';

st += '<style>'+
	'.menu { float: left; display: table; background: #EEF;'+
	'border: 2px solid #55A; padding: 10px; margin-bottom: 20px; }'+
	'.menu a { padding: 0; color: #55F; }'+
	'.menu a:hover { color: #00F; }'+
	'.menu a.active { font-weight: bold; background: #EEF; }'+
	'.menu span { display: inline-block; }'+
	'.menu span { margin-right: 5px; }'+
	'.menu span:last-child { margin-right: 0; }'+
	'</style>';

st += '<div class="menu">';
st += '<span>Валидаторы: '+
	'<a href="/validator/">Бренды</a>, '+
	'<a href="/places/errors/">place=*</a>, '+
	'<a href="/places/">Населенные пункты</a>, '+
	'<a href="/addr/">Адресация</a>, '+
	'<a href="/operators/">Операторы</a>'+
	' ';
st += '<span>Инструменты: '+
	'<a href="/tags/">Справочник тегов</a>, '+
	'<a href="/tags/opening_hours.html">Часы работы</a>, '+
	'<a href="/search.html">Поиск в ЯК</a>';
st += '</span>';
st += '<span>Карты: '+
	'<a href="/recycling/">Пункты переработки мусора</a>, '+
	'<a href="/latlon.html">Геокодер</a>, '+
	'<a href="/OSMvsNarod.html">Сравнение с НЯК</a>, '+
	'<a href="http://clubs.ya.ru/4611686018427464811/replies.xml?item_no=110">Стиль для JOSM</a>';
st += '</span>';
st += '</div>';
st += '<hr style="clear: both"/>';
document.write(st);

$$('.menu a', function(x){
	var L = (''+document.location).replace(/#.+/, '');
	if (L == x.href) x.className = 'active';
});
