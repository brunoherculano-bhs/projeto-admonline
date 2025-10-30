Adianti.loading = true;

Application = {};
Application.translation = {
    'en' : {
        'loading' : 'Loading',
        'close'   : 'Close',
        'insert'  : 'Insert',
        'open_new_tab' : 'Open on a new tab'
    },
    'pt' : {
        'loading' : 'Carregando',
        'close'   : 'Fechar',
        'insert'  : 'Inserir',
        'open_new_tab' : 'Abrir em uma nova aba'
    },
    'es' : {
        'loading' : 'Cargando',
        'close'   : 'Cerrar',
        'insert'  : 'Insertar',
        'open_new_tab' : 'Abrir en una nueva pestaña'
    }
};

Adianti.onClearDOM = function(){
	/* $(".select2-hidden-accessible").remove(); */
	/* $(".colorpicker-hidden").remove(); */
	$(".pcr-app").remove();
	$(".select2-display-none").remove();
	$(".tooltip.fade").remove();
	$(".select2-drop-mask").remove();
	/* $(".autocomplete-suggestions").remove(); */
	$(".datetimepicker").remove();
	$(".note-popover").remove();
	$(".dtp").remove();
	$("#window-resizer-tooltip").remove();
};


Adianti.showLoading = function() {
    if (Adianti.loading)
    {
        __adianti_block_ui(Application.translation[Adianti.language]['loading']);
    }
}

Adianti.onBeforeLoad = function(url) {
    setTimeout(function(){
        Adianti.showLoading()
    }, 400);
    
    if (url.indexOf('&static=1') == -1 && url.indexOf('&noscroll=1') == -1) {
        $("html, body").animate({ scrollTop: 0 }, "fast");
    }
};

Adianti.onAfterLoad = function(url, data)
{ 
    __adianti_unblock_ui( true );
};

// set select2 language
$.fn.select2.defaults.set('language', $.fn.select2.amd.require("select2/i18n/pt"));

// adicionando a funcao enter->tab
$('body').on('keydown', 'input, select, textarea', function(e) {
var self = $(this)
  , form = self.parents('form:eq(0)')
  , focusable
  , next
  , prev
  ;
if (e.shiftKey) {
 if (e.keyCode == 13) {
     focusable =   form.find('input,a,select,button,textarea').filter(':visible');
     prev = focusable.eq(focusable.index(this)-1); 
     if (prev.length) {
        prev.focus();
     } else {
        form.submit();
    }
  }
}
  else
if (e.keyCode == 13) {
    focusable = form.find('input,a,select,button,textarea').filter(':visible');
    next = focusable.eq(focusable.index(this)+1);
    if (next.length) {
        next.focus();
    } else {
        form.submit();
    }
    return false;
}
});
