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
	