function controllaDataNascita (data, annomin, annomax) {
    if ((data != "") && (data != null)) {
        let datam = moment(data, "DD-MM-YYYY" );
        let annom = moment(datam).year();
        if ((datam.isValid()) && (annom > annomin) && (annom < annomax) ) { return true; } else { return false;}
    } else {
        return true;
    }
}

function controllaData (data) {
    if ((data != "") && (data != null)) {
    let datam = moment(data, "DD-MM-YYYY" );
    let annom = moment(datam).year();
    //console.log ("Funzione controllaData: verifica della data " + data)
    if ((datam.isValid()) && (annom > 2010) && (annom < 2050) ) { return true; } else { return false;}
    } else { return true;}
}
	

function postToDownload( template, filetitle, title, from, where, orderBY, nomiCampiA, dataNonDataA, columnColoring){

    
        //la POST via ajax non funziona	
    // postData= {title: title, from: from, where: where, orderBY: orderBY, nomiCampiA: nomiCampiA, dataNonDataA: dataNonDataA};

		// console.log ("00anagrafica.php - addAnagrafica - postData a 00qry_insertAnagrafica.php ");
		// console.log (postData);
		// $.ajax({
		// 	type: 'POST',
		// 	url: "99downloadExcel.php",
		// 	data: postData,
		// 	dataType: 'json',
		// 	success: function(data){
		// 		console.log (data);
		// 	},
	    //     error: function(){
	    //         alert("Errore: contattare l'amministratore fornendo il codice di errore '20AnagraficaSoci ##postToDownload##'");     
	    //     }
		// });


    let form = $(document.createElement('form'));
    $(form).attr("action", "99downloadExcel.php");
    $(form).attr("method", "POST");
    $(form).css("display", "none");

    let inputTemplate = $("<input>")	.attr("type", "text").attr("name", "template").val(template);
    $(form).append($(inputTemplate));

    let inputFileTitle = $("<input>")	.attr("type", "text").attr("name", "filetitle").val(filetitle);
    $(form).append($(inputFileTitle));

    let inputTitle = $("<input>")		.attr("type", "text").attr("name", "title").val(title);
    $(form).append($(inputTitle));

    let inputFrom = $("<input>")		.attr("type", "text").attr("name", "from").val(from);
    $(form).append($(inputFrom));

    let inputWhere = $("<input>")		.attr("type", "text").attr("name", "where").val(where);
    $(form).append($(inputWhere));

    let inputOrderBY = $("<input>")		.attr("type", "text").attr("name", "orderBY").val(orderBY);
    $(form).append($(inputOrderBY));

    let inputNomiCampiA = $("<input>")	.attr("type", "text").attr("name", "nomiCampiA").val(JSON.stringify(nomiCampiA));
    $(form).append($(inputNomiCampiA));

    let inputDataNonDataA = $("<input>").attr("type", "text").attr("name", "dataNonDataA").val(JSON.stringify(dataNonDataA));
    $(form).append($(inputDataNonDataA));

    let inputColumnColoring = $("<input>")   .attr("type", "text").attr("name", "columnColoring").val(JSON.stringify(columnColoring));
    $(form).append($(inputColumnColoring));

    form.appendTo( document.body );
    $(form).submit();
    $(form).remove();
    
}

function firstUpperOnly(str) {

    let strLower = str.toLowerCase()
    const arr = strLower.split(" ");

    for (var i = 0; i < arr.length; i++) {
        arr[i] = arr[i].charAt(0).toUpperCase() + arr[i].slice(1);
    }

    const strFinal = arr.join(" ");

    return strFinal;
}

function timestampToDate(isoDate) {
    if (!isoDate || isoDate === "0000-00-00" || isoDate === "1900-01-01") {
        return "";
    }

    const date = new Date(isoDate);
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0'); // Mesi da 0 a 11
    const day = String(date.getDate()).padStart(2, '0');

    return `${year}-${month}-${day}`;
}


function normalizeName(nome, cognome) {
    let fileName = nome + cognome;
    
    // Rimuove caratteri speciali
    fileName = fileName.replace(/[\|&;\$%@"<>\(\)\+,]/g, "");
    fileName = fileName.replace("'", "");
    fileName = fileName.replace(" ", "");
    fileName = fileName.replace("-", "");
    fileName = fileName.replace("`", "");

    // Trasforma le lettere accentate in lettere normali
    fileName = fileName.normalize("NFD").replace(/[\u0300-\u036f]/g, "");

    return fileName;
}

