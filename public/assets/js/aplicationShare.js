/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function _l(d){return;
    console.log(d);
}
function calcularVocIndividual(voc, cantidad, densidad, vocInd) { 
    if(!voc.val())
        voc.val(0);
    if(!densidad.val())
        densidad.val(0);
    
    //console.log(voc.val()+' - '+cantidad.val()+' - '+densidad.val());
    var res = parseFloat(voc.val()) * ( 1000 * parseFloat(cantidad.val()) / parseFloat(densidad.val()) );//console.log(res.toFixed(2));
    if (!res) {
        vocInd.val('0');
        return 0;
    }
    vocInd.val(res.toFixed(4));
    return parseFloat(vocInd.val());
}
function calcularPorcentaje(cantidad, totCant){
    if(!cantidad.val()){
        cantidad=cantidad.text();
    }else{
        cantidad=cantidad.val();
    }
    var cantidad=parseFloat(cantidad);
    if(isNaN(cantidad))return 0;
    return (cantidad / totCant * 100);
}
var carculatedOnce=false;
function calcular() { 
        var totCant = importeTot = totDensidad = totVocInd = 0;
        $('.cantidad').each(function () {
            if ($(this).val().length)
                totCant += parseFloat($(this).data('val'));
        });
        totCant = totCant;
        $('.cantidad').each(function () {
            if (!$(this).val().length)
                return;
            $parent = $(this).parent().parent();
            totDensidad += parseFloat($parent.find('.densidad').val());
            //SET IMPORTE
            var importe = parseFloat($(this).data('val')) * parseFloat($parent.find('.coste').val());
            if(!importe)importe=0;

            
            $parent.find('.importe').val(importe.toFixed(4));
            importeTot += parseFloat(importe);
            
            //SET PORCENTAJE
            $parent.find('.porcentaje').val(calcularPorcentaje($(this), totCant));
            //SET VOC INDIVIDUAL
            totVocInd += calcularVocIndividual($parent.find('.voc'), $(this), $parent.find('.densidad'), $parent.find('.vocIndividual'));
            

        });
        importeTot = importeTot;
        
        //SET VOC TOTALES FORMULA
        var volFormula = totCant / parseInt($('#densidad-val').val());
        var vocTotales = totVocInd / volFormula;
        $('.vocTotales').val((vocTotales / 1000).toFixed(4));
        $('.importeTotal').val(importeTot.toFixed(4));
        $('.pesoTotal').val(totCant.toFixed(4));
        if (!carculatedOnce){
            $('#restablecer').data('pesoTotal', totCant);
        }
		//$('.precioXkg').val('importeTot: '+importeTot+' totCant: '+totCant);
        $('.precioXkg').val((importeTot / totCant).toFixed(4));
        carculatedOnce=true;
		
		if(editingBase){
			if(Math.round(totCant)!=100){
                                bootbox.alert('Esta formula no esta reconvertida a 100, recuerda editarla antes de finalizar.');
			}
		}
        return false;
    }

    function calcularPrecioTeorico(coste,porcentaje_teorico){
        var res=parseFloat(coste*porcentaje_teorico);
        if(isNaN(res))return 0;
        return res.toFixed(3);
    }

    function calcularPorcentajePesado(cant_pesada, sumatorio_cant_pesada){
        if(sumatorio_cant_pesada==0)return 0;
        var res=parseFloat(cant_pesada/sumatorio_cant_pesada*100);
        if(isNaN(res))return 0;
        return res.toFixed(3);
    }

    function calcularCantTeorica($, el, total){

        //var result= (100-sumatorioElemento($,'.porcentaje_teorico',['carga','tio2','aditivos','disolvente','ligante'])).toFixed(3);
        var res= parseFloat(el.find('.porcentaje_teorico').val()/100*total);
        //trick for now
        //if(result==328.667)result=353.150;
        
        if(isNaN(res))return 0;
        return res.toFixed(3);
        
        
        /*var agua=el.find('.codigo').val()=='1000';
        if(agua){
            var tipos=['tio2','carga','disolvente','ligante','aditivos'];
            let sumatorio=sumatorioElemento($, '.porcentaje_teorico',tipos);
            return (100-sumatorio).toFixed(3);
        }else{

            return (el.find('.porcentaje_teorico').val()/100*total).toFixed(3);
        }
        */
    }

    function sumatorioElemento($, elemento, tipos=[], debug=false){
        var sumatorioElemento=0;
        $('#append tr.new-rows').each(function(i,el){
            el=$(el);

            if(debug){
                //_l('sumatorioElemento');
                //_l(elemento,tipos,el.find('select.tipo').val(),tipos.length,tipos.includes(el.find('select.tipo').val()),el.find(elemento).val());
            }


            if( (!tipos.length || tipos.includes(el.find('select.tipo').val())) && el.find(elemento).val()!='')
                sumatorioElemento+=parseFloat(el.find(elemento).val());

            if(debug){
                //_l('sumatorioElemento++');
                //_l(sumatorioElemento);
            }
            
        })
        if(!sumatorioElemento)  return 0; 
        var res= parseFloat(sumatorioElemento);
        if(isNaN(res))return 0;

        return res.toFixed(3);

    }

    function sumatorioElementoDoble(el1, el2, tipos=[]){

        var sumatorio=0;
        $('#append tr.new-rows').each(function(i,el){
            el=$(el);
            if( (!tipos.length || tipos.includes(el.find('select.tipo').val())) && el.find(el1).val()!='' && el.find(el2).val()!='')
                sumatorio+=parseFloat(el.find(el1).val())*parseFloat(el.find(el2).val());

        });
        sumatorio=parseFloat(sumatorio);
        if(isNaN(sumatorio))return 0;
        return sumatorio;

    }

    function calcularPorcentajeSolido($,tipo){//f4
        _l(['FUNCTION calcularPorcentajeSolido',tipo]);
        if(tipo=='teorico'){
            var cantidad='.cantidad_teorica';
        }else if(tipo=='pesado'){
            var cantidad='.cantidad_pesada';
        }else{
            return 0;
        }
        var sumatorioCant=sumatorioElemento($,cantidad);
        var sumatorio=0;
        $('#append tr.new-rows').each(function(i,el){
            el=$(el);
            sumatorio+=parseFloat(parseFloat(el.find('.solidos').val())/100)*parseFloat(el.find(cantidad).val());
        });
        _l(['sumatorio fomulacion f4',sumatorio]);
        _l(['sumatorioCant',sumatorioCant])
        if(!sumatorioCant)return 0;
        var res= parseFloat((sumatorio/sumatorioCant)*100);
        if(isNaN(res))return 0;
        return res.toFixed(3);

    }

    function calcularPvc($,tipo){//f5
        _l(['FUNCTION calcularPvc',tipo]);
        
        if(tipo=='teorico'){
            var cantidad='.cantidad_teorica';
        }else if(tipo=='pesado'){
            var cantidad='.cantidad_pesada';
        }else{
            return 0;
        }
        var tipos=['tio2','carga'];
        var tipos2=['tio2','carga','disolvente','ligante'];
        var sumatorioDensidad=sumatorioElemento($,'.densidad',tipos);
        var sumatoriof51=0;
        var sumatoriof52=0;
        $('#append tr.new-rows').each(function(i,el){
            el=$(el);
            if( (!tipos.length || tipos.includes(el.find('select.tipo').val())))
                sumatoriof51+=(parseFloat(el.find('.solidos').val()/100)*parseFloat(el.find(cantidad).val()))/parseFloat(el.find('.densidad').val());
            if( (!tipos2.length || tipos2.includes(el.find('select.tipo').val())))
                sumatoriof52+=(parseFloat(el.find('.solidos').val()/100)*parseFloat(el.find(cantidad).val()))/parseFloat(el.find('.densidad').val());
        });
        
        if(!sumatoriof52)return 0.00;
        var res= parseFloat((sumatoriof51/sumatoriof52)*100);
        if(isNaN(res))return 0;
        return res.toFixed(3);
    }

    

    function inArray(needle, haystack) {
        var length = haystack.length;
        for(var i = 0; i < length; i++) {
            if(haystack[i] == needle) return true;
        }
        return false;
    }

    function calcularPorcentajeDensidad($, tipo, fixed=true){//f6
        _l(['FUNCTION calcularPorcentajeDensidad',tipo]);
        var medido=false;
        var desnidadMedido=false;
        if(tipo=='teorico'){
            var porcentaje='.porcentaje_teorico';
            var cantidad='.cantidad_teorica';
        }else if(tipo=='pesado'){
            var porcentaje='.porcentaje_pesado';
            var cantidad='.cantidad_pesada';
        }else if(tipo=='medido'){
            var porcentaje='.porcentaje_pesado';
            var cantidad='.cantidad_pesada';
            desnidadMedido=parseFloat($('.densidad_medido').val());
        }else{
            return 0;
        }
        var sumCant=parseFloat(sumatorioElemento($,cantidad));
        var sumFDen=0;
        $('#append tr.new-rows').each(function(i,el){
            el=$(el);
            if(desnidadMedido && !isNaN(desnidadMedido)){
                densidad=desnidadMedido; 
            }else{
                densidad=parseFloat(el.find('.densidad').val());       
            }
            sumFDen+=parseFloat(el.find(cantidad).val())/densidad;
        });
        sumFDen=sumFDen*1000;
        _l(['sumCant',sumCant]);
        _l(['sumFDen f6',sumFDen]);
        sumatorio=parseFloat(sumCant)/parseFloat(sumFDen);
        _l(['sumatorio',sumatorio]);
        
//        if(fixed){
//            _l('calcularPorcentajeDensidad');
//            _l(tipo);
//            _l(sumCant);
//            _l(sumatorio);
//            _l(isNaN(sumatorio));
//            _l(sumatorio==Infinity);
//        }
        if(isNaN(sumatorio) || sumatorio==Infinity)return 0;
        if(fixed){
            return (sumatorio).toFixed(2);
        }else{
            return sumatorio;  
        }
    }

    function calcularPorcentajeTio($,tipo){//f7
        if(tipo=='teorico'){
            var porcentaje='.porcentaje_teorico';
        }else if(tipo=='pesado'){
            var porcentaje='.porcentaje_pesado';
        }else{
            return 0;
        }
        var res= parseFloat(sumatorioElemento($,porcentaje,['tio2']));
        if(isNaN(res))return 0;
        return res.toFixed(3);
    }

    function calcularPorcentajeLigante($,tipo){//f8
        if(tipo=='teorico'){
            var porcentaje='.porcentaje_teorico';
        }else if(tipo=='pesado'){
            var porcentaje='.porcentaje_pesado';
        }else{
            return 0;
        }
        var res= parseFloat(sumatorioElemento($,porcentaje,['ligante']));
        if(isNaN(res))return 0;
        return res.toFixed(3);
    }

    function calcularPrecioEuKg($, tipo){//f9
        if(tipo=='teorico'){
            var porcentaje='.porcentaje_teorico';
        }else if(tipo=='pesado'){
            var porcentaje='.porcentaje_pesado';
        }else if(tipo=='medido'){
            var porcentaje='.porcentaje_pesado';
        }else{
            return 0;
        }
        let sumatorio=sumatorioElementoDoble('.coste', porcentaje);
        
        
        var res= parseFloat(sumatorio/100);
        if(isNaN(res))return 0;
        return res.toFixed(3);


    }

    function calcularPrecioEuLt($, tipo){//f10
//                _l('************************');
//                _l(tipo);
//                _l(calcularPrecioEuKg($,tipo));
//                _l(calcularPorcentajeDensidad($,tipo));
//                _l((calcularPrecioEuKg($,tipo)*calcularPorcentajeDensidad($,tipo)).toFixed(3));
//                _l('-----------------------');
        let res=parseFloat(calcularPrecioEuKg($,tipo)*calcularPorcentajeDensidad($,tipo,false));
        if(isNaN(res))return 0;
        return res.toFixed(3);


        
        //return (calcularPrecioEuKg($,tipo)*calcularPorcentajeDensidad($,tipo,false)).toFixed(3);
    }


    






    
    

