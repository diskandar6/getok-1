function toastd(pesan,kind='success',delay=200,autohide=true){
	var b=Math.floor(Math.random() * 1000000);
	if(kind=='success')var c='00C851';else
	if(kind=='danger')var c='ff4444';else
	if(kind=='info')var c='33b5e5';else
	if(kind=='warning')var c='ffbb33';
	var a='<div role="alert" aria-live="assertive" id="t'+b+'" onclick="hidetoast(\'t'+b+'\')" data-autohide="'+autohide+'" aria-atomic="true" data-delay="'+delay+'" class="toast col-lg-3 col-md-6 col-sm-8 z-depth-1-half card" style="background:#'+c+';opacity:0.8;position:fixed;right:0;top:0;margin:20px;color:#000;z-index:9999">';
	a+='  <div class="toast-body">';
	a+=pesan;
	a+='  </div>';
	a+='</div>';
	$('body').append(a);
	$('#t'+b).toast('show');
}
function hidetoast(v){
	$('#'+v).toast('hide');
}
function load_data(id,url,debug=false,add=false){
    $('#'+id).parent().prepend("<div class='spinner-border text-primary a"+id+"' role='status' style='position:absolute;left:50%'><span class='sr-only'>Loading...</span></div>");
	$.get(url,function(data){if(data=='')$(".a"+id).remove();
	    if(debug)alert(data);
	    var table=$('#'+id).DataTable();
		if(add)
			table.rows.add(JSON.parse(data)).draw();
		else
			table.clear().rows.add(JSON.parse(data)).draw();
		table.columns.adjust();
		$(".a"+id).remove();
	});
}
var ordering=true;
function disableordering(){
    ordering=false;
}
function load_first(id,url,debug=false,LC=true,sch=true,col=0,info=true,asc='asc',pg=true,scrolltable=false){
    $.get(url,function(data){
        if(debug)alert(data);
        var data=JSON.parse(data);
        var pr={data:data,
			"bLengthChange": LC,
			"searching": sch,
			"paging":pg,
			"ordering":ordering,
			"scrollX": scrolltable,
			"drawCallback":function(settings){if(typeof reformattable === "function")reformattable(settings);},
			"fnRowCallback":function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {if(typeof reformattable_ === "function")reformattable_(nRow, aData, iDisplayIndex, iDisplayIndexFull);},
        }
    	if(col>0){
    		pr.scrollY=col+'px';
    		pr.scrollCollapse=true;
    		pr.paging=false;
    	}
    	pr.info=info;
    	pr.order=[0, asc ];
        $('#'+id).DataTable(pr);
    })
}

/*
    function reformattable_(nRow, aData, iDisplayIndex, iDisplayIndexFull){
        var data=JSON.parse(aData[0]);
        var a=data[0]+'<br>'+data[1]+'<br><img src="'+data[2]+'?w=1&h=1&nw=50&f=1&t=1" width="50" class="rounded-circle img-thumbnail">';
        if(data[3]!='')a+='<img src="'+data[3]+'?w=1&h=1&nw=50&f=1&t=1" width="50" class="rounded-circle img-thumbnail">';
        a+='<br>'+data[4]+'<br>'+data[5]+'<br>'+data[6];
        $('td:eq(0)',nRow).html(a);
    }
*/
function check_id(){
	attr = $('body').attr('id___');
	return (typeof attr !== typeof undefined && attr !== false);
}

function get_id(){
	return $('body').attr('id___');
}

function set_id(id){
	return $('body').attr('id___',id);
}

function remove_id(){
	$('body').removeAttr('id___');
}

function delete_(id){
	$('body').attr('delete__',id);
}

function alert_ok(data,text='Berhasil disimpan!'){
	var res=false;
	if(data=='ok'){
        toastr.success(text, '', {positionClass: 'md-toast-bottom-right'});
        $('#toast-container').attr('class','md-toast-bottom-right');
        res=true;
    }else{
        toastr.error(data, '', {positionClass: 'md-toast-bottom-right'});
        $('#toast-container').attr('class','md-toast-bottom-right');
    }
    return res;
}

function delete__(fun){
	var id = get_id();
	if (typeof id !== typeof undefined && id !== false){
		$.post(PT,{delete:id},function(data){
			if(alert_ok(data,'Success!'))
                eval(fun);
            remove_id();
			$('#modal-delete').modal('hide');
		});
	}
}

function isFloat(n){
	return Number(n) === n && n % 1 !== 0;
}
function add_option(id,data,clear=false){
    clear_option(id,clear);
    for(var i=0;i<data.length;i++)
        $('#'+id).append(new Option(data[i].text, data[i].value));
}
function clear_option(id,clear){
    if(clear)
        $('#'+id).children('option').remove();
    else
        $('#'+id).children('option:not(:first)').remove();
}
function replaceAll(string, search, replace) {
    return string.split(search).join(replace);
}
function copythis(v){
    v.select();
    v.setSelectionRange(0, 99999); /*For mobile devices*/
    document.execCommand("copy");
    toastr.success('copied!', '', {positionClass: 'md-toast-bottom-right'});
    $('#toast-container').attr('class','md-toast-bottom-right');
}
