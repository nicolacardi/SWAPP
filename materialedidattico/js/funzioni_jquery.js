// JavaScript Document



// FUNZIONI della pagina Report per mostrare/nascondere le combobox ***********************************************************************
function nascondi()
{ 
	$('.troptcarichi').hide();
	$('.troptscarichi').hide();
	$('.troptarticoli').hide();
}

function mostracarichi()
{	
	$('.troptcarichi').show(1000);
}

function mostrascarichi()
{	
	$('.troptscarichi').show(1000);
}

function mostraarticoli()
{	
	$('.troptarticoli').show(1000);
}

function nascondicarichi()
{	
	$('.troptcarichi').hide(300);
}

function nascondiscarichi()
{	
	$('.troptscarichi').hide(300);
}

function nascondiarticoli()
{	
	$('.troptarticoli').hide(300);
}
// FINE FUNZIONI della pagina REPORT per mostrare/nascondere le combobox ***********************************************************************

// FUNZIONI delle pagine ARTICOLI, CLIENTI, FORNITORI, MOVIMENTI per bloccare lo scorrimento in alto delle righe********************************

/* Copyright (c) 2009 Mustafa OZCAN (http://www.mustafaozcan.net)
 * Released under the MIT license
 * Version: 1.0.3
 * Requires: jquery.1.3+
 */
jQuery.fn.fixedtableheader = function (options) {

    var settings = jQuery.extend({
        headerrowsize: 3,  //numero di righe bloccate
        highlightrow: false,
        highlightclass: "highlight"
    }, options);

    this.each(function (i) {
        var $tbl = $(this);
        var $tblhfixed = $tbl.find("tr:lt(" + settings.headerrowsize + ")");
        var headerelement = "th";
        if ($tblhfixed.find(headerelement).length == 0)
            headerelement = "td";
        if ($tblhfixed.find(headerelement).length > 0) {
            $tblhfixed.find(headerelement).each(function () {
                $(this).css("width", $(this).width());
            });
            var $clonedTable = $tbl.clone().empty();
            var tblwidth = GetTblWidth($tbl);
            $clonedTable.attr("id", "fixedtableheader" + i).css({
                "position": "fixed",
                "top": "0", // "top": "50px", //questo definisce a che altezza si colloca la tabella clonata
                "left": $tbl.offset().left
            }).append($tblhfixed.clone()).width(tblwidth).hide().appendTo($("body"));
            if (settings.highlightrow)
                $("tr:gt(" + (settings.headerrowsize - 1) + ")", $tbl).hover(function () {
                    $(this).addClass(settings.highlightclass);
                }, function () {
                    $(this).removeClass(settings.highlightclass);
                });
            $(window).scroll(function () {
                $clonedTable.css({
                    "position": "fixed",
                    "top": "0", //"top": "50px",//questo definisce a che altezza si colloca la tabella clonata
                    "left": $tbl.offset().left - $(window).scrollLeft()
                });
                var sctop = $(window).scrollTop();
                var elmtop = $tblhfixed.offset().top;
				var hblock = 0; //var hblock = 50; //questo definisce a che altezza si blocca la tabella
                if (sctop > (elmtop - hblock) && sctop <= (elmtop + $tbl.height() - $tblhfixed.height()))  
                    $clonedTable.show();
                else
                    $clonedTable.hide();
            });
            $(window).resize(function () {
                if ($clonedTable.outerWidth() != $tbl.outerWidth()) {
                    $tblhfixed.find(headerelement).each(function (index) {
                        var w = $(this).width();
                        $(this).css("width", w);
                        $clonedTable.find(headerelement).eq(index).css("width", w);
                    });
                    $clonedTable.width($tbl.outerWidth());
                }
                $clonedTable.css("left", $tbl.offset().left);
            });
        }
    });

    function GetTblWidth($tbl) {
        var tblwidth = $tbl.outerWidth();
        return tblwidth;
    }
};

// FUNZIONI delle pagine ARTICOLI, CLIENTI, FORNITORI, MOVIMENTI per bloccare lo scorrimento in alto delle righe********************************

// FUNZIONI Sidenav per aprire e chiudere il menu laterale *************************************************************************************
function openNav() {
	//$('.sidenav').width('200px');
	//$('main').marginLeft('25%');
	
    $('.sidenav').fadeIn(500);

}

function closeNav() {

	$('.sidenav').fadeOut(300);
	
};


// FINE FUNZIONI Sidenav per aprire e chiudere il menu laterale *************************************************************************************

// FUNZIONE per lanciare la submit del form con id #target alla pressione del tasto ENTER ************************************************************

$('body').keypress(function(e){
		if (e.keyCode == 13)
		{
			$('#target').submit();
			//console.log ("premuto enter");
		}
}); //FINE $('body').keypress(function(e)
