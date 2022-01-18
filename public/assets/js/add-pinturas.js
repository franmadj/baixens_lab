/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//function calcular(object) {
//    var res = parseFloat(object.find('.voc').val()) * (1000 * parseFloat(object.find('.cantidad').val()) / parseFloat(object.find('.densidad').val())).toFixed(2);
//    if (!res) {
//        object.find('.vocIndividual').val('');
//        return;
//    }
//    object.find('.vocIndividual').val(res.toFixed(2));
//}
function log(d) {
    console.log(d);

}
var index_ini = 16;
var length;
var n;
var calculated = false;
jQuery(document).ready(function ($) {
    //SAVE A COPY OF SELECT WHICH ARE GONNA BE DUPLICATED
    var selectCodigos = $('#aClonar select.codigo').clone();
    selectCodigos.removeClass('select2-offscreen');

    var selectProductos = $('#aClonar select.producto').clone();
    selectProductos.removeClass('select2-offscreen');

    var selectTipos = $('#aClonar select.tipo').clone();
    selectTipos.removeClass('select2-offscreen');

    var noProcesarAjax = true;

    $('.nombre-fomula').focus();


    //POPULATE PRODUCT CODE ON PRODUCT CHANGE
    $('body').on('change', '.producto', function (e) {
        var $this = $(this);
        $.ajax({
            type: "POST",
            url: getCodigoProducto,
            data: {
                "_token": $('#token-ajax').find('input').val(),
                "id_prod": $(this).val()

            },
            success: function (data) {
                $this.parent().parent().find('.codigo').val(data).blur();

            }
        });
    });
    //POPULATE PRODUCT DATA
    $('body').on('blur', '.codigo', function (e, isTriggered) {
        isTriggered = typeof isTriggered == 'undefined' ? false : isTriggered;
        //_l('.codigo', isTriggered);
//        _l('isTriggered');
//        _l(isTriggered);
        var id = $(e.currentTarget).attr('id');
        //_l(id);
        //_l('codigo-' + (filasDeMas + 1));
        var isLastRow = (id == 'codigo-' + (filasDeMas + 1));
        var val = $(this).val();

        //_l(val);
        var $this = $(this);
        var $parent = $this.parent().parent();
        if (val == 0) {

            $parent.find('.coste').val(0);
            $parent.find('.solidos').val(0);
            $parent.find('.voc').val(0);
            $parent.find('.producto').val(0);
            $parent.find('.codigo').val(0);
            $parent.find('.densidad').val(0);
            $parent.find('.precio_teorico').val(0);
            return;
        }
        $.ajax({
            type: "POST",
            url: getCosteProducto,
            data: {
                "_token": $('#token-ajax').find('input').val(),
                "codigo_prod": val

            },
            success: function (data) {
                if (data.solidos == '') {
                    alert('Este producto no tiene solidos');
                }
                if (data.densidad == '') {
                    alert('Este producto no tiene densidad');
                }
                var $parent = $this.parent().parent();
                if (val == 549)
                    $parent.find('.porcentaje_teorico').attr('readonly', true);
                $parent.find('.coste').val(data.coste);
                $parent.find('.solidos').val(data.solidos);
                $parent.find('.voc').val(data.voc);
                $parent.find('.densidad').val(parseFloat(data.densidad));
                $parent.find('.producto').val(data.id);
                $parent.find('.producto').parent().find('.select2-chosen').text(data.productoName);
                if (!noAutoPopulateTipo)
                    $parent.find('select.tipo').val(data.tipo).change();

                if (isTriggered) {
                    if (isLastRow && !calculated) {
                        calculated = true;
                        calcularTotPinturas()
                        setTimeout(function () {
                            noAutoPopulateTipo = false;
                        }, 1000);
                    }
                }


            },
            dataType: 'json'
        });


        if (!$parent.find('.cantidad_pesada').val().length)
            $parent.find('.cantidad_pesada').val(0);
        return false;
    });

    $('.del-row').click(function () {
        $(this).parent().parent().remove();
        numFilas = parseInt($('#filasDeMas').val());
        $('#filasDeMas').val(numFilas - 1);
        reset_order_rows_table();
        $('#cantidad_pesada-2').blur();
        $('.new-rows').eq(0).find('.porcentaje_teorico').blur();
        return false;
    });

    $('.add-row').click(function (e) {
        aClonar = $('#aClonar').clone();
        numFilas++;
        addClon(numFilas, e, false);
        return false;
    });



    /*CALCULATE 
     * APORTACION PRECIO TEORICO
     * cantidad_teorica 
     * porcentaje_teorico_total 
     * cantidad_teorica_total
     */
    $('body').on('blur', '.porcentaje_teorico', function () {
        var $this = $(this);
        var $parent = $this.parent().parent();
        //_l(sumatorioElemento($,'.porcentaje_teorico',['carga','tio2','aditivo','disolvente','ligante']))

        var valor = $this.val();
        if (!valor) {
            $this.val(0.000);
        } else {
            $this.val(parseFloat(valor).toFixed(3));
        }

        var aguaTeorico = (100 - sumatorioElemento($, '.porcentaje_teorico', ['carga', 'tio2', 'aditivo', 'disolvente', 'ligante'])).toFixed(3);
        //_l('aguaTeorico')
        //_l(aguaTeorico);
        //var total=$('#ajustar_a').val();

        $('.codigo').each(function (i, el) {
            if ($(this).val() == 1000) {
                $(this).parent().parent().find('.porcentaje_teorico').val(aguaTeorico).attr('readonly', true);
            }


        });



        $parent.find('.aportacion_precio_teorico').val(calcularPrecioTeorico($parent.find('.coste').val(), $this.val()));

        var total = $('#ajustar_a').val();
        if (!total)
            total = 0;
        $('.cantidad_teorica').each(function (i, el) {
            $(el).val(calcularCantTeorica($, $(el).parent().parent(), total));

        });
        var sumatorioPt = sumatorioElemento($, '.porcentaje_teorico');
        $('.porcentaje_teorico_total').val(sumatorioPt);
        var sumatorioCt = sumatorioElemento($, '.cantidad_teorica');
        $('.cantidad_teorica_total').val(sumatorioCt);

    });

    $('#ajustar_a').keyup(function () {
        jQuery('.new-rows').eq(0).find('.porcentaje_teorico').blur();

    });

    //calcula porcentaje_pesado f2, cantidad_pesada_total
    $('body').on('blur', '.cantidad_pesada', function () {
        var valor = $(this).val();
        if (!valor) {
            $(this).val(0);
        } else {
            $(this).val(parseFloat(valor).toFixed(3));
        }

        var sumatorio = sumatorioElemento($, '.cantidad_pesada');
        $('.cantidad_pesada').each(function () {
            var $this = $(this);
            var $parent = $(this).parent().parent();

            $parent.find('.porcentaje_pesado').val(calcularPorcentajePesado($this.val(), sumatorio));
            $('.cantidad_pesada_total').val(sumatorio);

        });



    });


    var aClonar;
    var desc = Array();
    var prevButton = Array();
    //var tabIndex=18;
    var top = false;
    var currentPos = 0;
    /**
     * 
     * @param {type} posthe next index position  for names
     * @param {type} target row fromthe new row will be added
     * @returns {undefined}
     */
    function addClon(pos, target, automatic) { //return;
        currentPos++;
        jQuery('#filasDeMas').val(pos - 1);
        aClonar.removeAttr('id');
        aClonar.addClass('new-rows');
        aClonar.find('input').val('');
        aClonar.find('.codigo').attr('name', 'det-codigo-' + pos).attr('id', 'codigo-' + pos).val('');
        aClonar.find('.cantidad_pesada').attr('name', 'det-cantidad-' + pos).attr('id', 'cantidad_pesada-' + pos).val('');

        var newSelectProductos = selectProductos.clone();
        newSelectProductos.attr('id', 'producto-' + pos).attr('name', 'det-producto-' + pos).val('0');
        aClonar.find('.producto').parent().html(newSelectProductos);
        newSelectProductos.select2({
            placeholder: "Select an option",
            allowClear: true
        });

        var productValues = '<input type="hidden" class="coste"> <input type="hidden" class="densidad"> <input type="hidden" class="solidos"> <input type="hidden" class="voc"> <input type="hidden" class="vocIndividual" value="0">';
        aClonar.find('.product_values').append(productValues);


        var newSelectTipos = selectTipos.clone();
        newSelectTipos.attr('id', 'tipo-' + pos).attr('name', 'det-tipo-' + pos).val('agua');
        aClonar.find('select.tipo').parent().html(newSelectTipos);
        newSelectTipos.select2({
            placeholder: "Select tipo",
            allowClear: true
        });

        aClonar.find('.porcentaje_teorico').attr('name', 'det-porcentaje_teorico-' + pos).attr('id', 'porcentaje_teorico-' + pos).val('');
        aClonar.find('.porcentaje_pesado').attr('name', 'det-porcentaje_pesado-' + pos).attr('id', 'porcentaje_pesado-' + pos).val('');
        aClonar.find('.aportacion_precio_teorico').attr('name', 'det-aportacion_precio_teorico-' + pos).attr('id', 'aportacion_precio_teorico-' + pos).val('');
        aClonar.find('.cantidad_teorica').attr('name', 'det-cantidad_teorica-' + pos).attr('id', 'cantidad_teorica-' + pos).val('');


        //if (prevButton[pos - 1]) prevButton[pos - 1].css('display', 'none');
        var boton = $('<button/>', {
            text: '-',
            class: 'btn red',
            style: 'padding:1px 16px;',
            type: "button",
            click: function () {
                //if(prevButton[pos-1]){ prevButton[pos-1].css('display','inherit').addClass('clickeable-menos'); botonMenos=prevButton[pos-1];}
                jQuery(this).parent().parent().remove();
                numFilas = parseInt(jQuery('#filasDeMas').val());
                jQuery('#filasDeMas').val(numFilas - 1);
                reset_order_rows_table();
                jQuery('#cantidad_pesada-2').blur();
                jQuery('.new-rows').eq(0).find('.porcentaje_teorico').blur();
                return false;
            }
        });
        //botonMenos=boton;
        //prevButton[pos] = boton;
        aClonar.find('.boton').html(boton);

        var boton_mas = $('<button/>', {
            text: '+',
            class: 'btn green',
            style: 'padding:1px 14px;',
            type: "button",
            click: function (e) {
                aClonar = $('#aClonar').clone();
                numFilas++;
                addClon(numFilas, e, false);
                return false;
            }
        });
        aClonar.find('.boton').append(boton_mas);

        if (target.target) {
            new_target = $(target.target).parent().parent();
            new_target.after(aClonar);
        } else {
            jQuery("#append").append(aClonar);

        }


        // jQuery('#aClonar').after(aClonar);


        //automatic= se añadieron filas de forma automatica en el bucle for
        if (!automatic) {
            aClonar.show();
            reset_order_rows_table();
            aClonar.find('.codigo').focus();
        }

        if (top) {//solo cuando se añade fila y no cuando se borra
            top = false;
            //_l('top');
            $("html, body").animate({scrollTop: aClonar.offset().top - 200}, 1000);
        }
        //aClonar.find("td:first").find('.codigo').focus();
    }

    $('.plus-button').click(function (e) {
        aClonar = $('#aClonar').clone();
        numFilas++;
        addClon(numFilas, e, false);
        return false;
    });


    // reorderna los nombres de las campos cuando nueva fila es introducida para mantener el order cuando se guarde(no cuando se hace de forma automatica por el bucle)
    function reset_order_rows_table() {
        index = index_ini;

        $('#append tr').each(function (s) {
            var i = s + 1;
            var el = $(this);
            if (el.is(':visible')) {

                el.find('.td_codigo').find('input').attr('tabindex', index).attr('name', 'det-codigo-' + i).attr('id', 'codigo-' + i);
                index++;
                //_l(index);
                el.find('.cantidad_pesada').attr('name', 'det-cantidad-' + i).attr('tabindex', index).attr('id', 'cantidad_pesada-' + i);
                index++;
                //_l(index);
                el.find('.td_prod').find('.select2-focusser').attr('tabindex', index);
                el.find('.td_prod').find('select.form-control').attr('name', 'det-producto-' + i).attr('id', 'producto-' + i);
                //el.find('.td_prod').find('select').attr('name', 'det-producto-' + i).attr('id', 'producto-' + i);
                index++;
                el.find('.tipos').find('.select2-focusser').attr('tabindex', index);
                el.find('select.tipo').attr('name', 'det-tipo-' + i).attr('id', 'tipo-' + i);
                index++;
                //el.find('.tipo').attr('name', 'det-procentaje_teorico-' + i).attr('tabindex', index).attr('id', 'procentaje_teorico-' + i);
                //index++;
                el.find('.porcentaje_teorico').attr('name', 'det-porcentaje_teorico-' + i).attr('tabindex', index).attr('id', 'porcentaje_teorico-' + i);


                el.find('.cantidad_teorica').attr('name', 'det-cantidad_teorica-' + i).attr('id', 'cantidad_teorica-' + i);
                el.find('.porcentaje_pesado').attr('name', 'det-porcentaje_pesado-' + i).attr('id', 'porcentaje_pesado-' + i);
                el.find('.aportacion_precio_teorico').attr('name', 'det-aportacion_precio_teorico-' + i).attr('id', 'aportacion_precio_teorico-' + i);

                index++;
                //_l(index);

            }

        });
        $('#enviar_formula').attr('tabindex', index);

    }
    $('#enviar_formula').click(function (e) {
        $('.error-validation,.success-validation').html('');
        e.preventDefault();

        var errorProductos = false;
        var errorFormula = ($('input[name="nombre"]').val() == '' || $('input[name="pintura_ajustar_a"]').val() == '' || $('select[name="pintura_tipo"]').val() == '' || $('select[name="pintura_estado"]').val() == '');
        $('tr.new-rows').each(function (el, i) {
            $this = $(this);
            if (($this.find('.codigo').val() == '' || $this.find('select.producto').val() == '' || $this.find('select.tipo').val() == '' || $this.find('.porcentaje_teorico').val() == '') && $this.find('.cantidad_pesada').val() != '') {
                errorProductos = true;
                //console.log($this.find('.codigo').val()=='' , $this.find('select.producto').val()=='' , $this.find('select.tipo').val()=='' , $this.find('.porcentaje_teorico').val()=='');
            }

        });
        if (errorProductos || errorFormula) {
            $('.error-validation').html('<div class="alert alert-warning"> <strong>Atención!! </strong> Hay campos sin rellenar . </div>');
            $(window).scrollTop(0);
            return false;
        }


        bootbox.confirm('Formula Finalizada?', function (result) {
            if (result) {
                if (typeof addingBase != undefined && !editingBase) {
                    var addBaseTotCant = 0;
                    $('.cantidad').each(function () {
                        if ($(this).val().length)
                            addBaseTotCant += parseFloat($(this).val());

                    });
                    var addBaseValorPromedio = 100 / addBaseTotCant;
                    $('.cantidad').each(function () {
                        //SET CANTIDAD
                        if ($(this).val().length) {
                            var newCant = parseFloat($(this).val()) * addBaseValorPromedio;
                            $(this).data('val', newCant)

                        }
                        //_l($(this).val());
                    });
                }

                $('#formula_form').submit();
            } else {
                //return false;
            }



        });



    });

    $('#calcular_campos').click(function () {
        _l('calcular_campos');
        $('.porcentaje_solidos_teorico').val(calcularPorcentajeSolido($, 'teorico'));
        $('.porcentaje_solidos_pesado').val(calcularPorcentajeSolido($, 'pesado'));

        $('.pvc_teorico').val(calcularPvc($, 'teorico'));
        $('.pvc_pesado').val(calcularPvc($, 'pesado'));

        $('.densidad_teorico').val(calcularPorcentajeDensidad($, 'teorico'));
        $('.densidad_pesado').val(calcularPorcentajeDensidad($, 'pesado'));

        $('.porcentaje_tio_teorico').val(calcularPorcentajeTio($, 'teorico'));
        $('.porcentaje_tio_pesado').val(calcularPorcentajeTio($, 'pesado'));

        $('.porcentaje_ligante_teorico').val(calcularPorcentajeLigante($, 'teorico'));
        $('.porcentaje_ligante_pesado').val(calcularPorcentajeLigante($, 'pesado'));

        $('.precio_euro_kg_teorico').val(calcularPrecioEuKg($, 'teorico'));
        $('.precio_euro_kg_pesado').val(calcularPrecioEuKg($, 'pesado'));

        $('.precio_euro_lt_teorico').val(calcularPrecioEuLt($, 'teorico'));
        $('.precio_euro_lt_pesado').val(calcularPrecioEuLt($, 'pesado'));

        $('.precio_euro_lt_medido').val(calcularPrecioEuLt($, 'medido'));

    });



    var filasDeMas = parseInt(jQuery('#filasDeMas').val());



    var numFilas = 1 + filasDeMas;
    $('#uno-mas').click(function (e) {
        unoMas();
    });


    function unoMas() {
        aClonar = $('#aClonar').clone();
        numFilas++;
        addClon(numFilas, false, false);

    }
    $('body').on('keypress', window, function (event) {
        var key = event.which;
        //_l(key);
        //+ 43
        //- 45
        if (key == 43) {
            //_l($(document.activeElement));
            event.preventDefault();
            append = true;
            top = true;
            unoMas();
        } /*else if (key == 45) {
         event.preventDefault();
         $('#append tr:last').find('.boton').find('.red').click();
         }*/


    });



    n = 2;
    length = cant.length;



    setTimeout(function () {
        //loading(false);
        calcular_voc();
    }, 500);

    function calcular_voc() {
        var totCant = totVocInd = 0;
        $('.cantidad_pesada').each(function () {
            if ($(this).val().length)
                totCant += parseFloat($(this).data('val'));
        });

        $('.cantidad_pesada').each(function () {
            if (!$(this).val().length)
                return;
            $parent = $(this).parent().parent();


            //SET VOC INDIVIDUAL
            totVocInd += calcularVocIndividual($parent.find('.voc'), $(this), $parent.find('.densidad'), $parent.find('.vocIndividual'));


        });




        //SET VOC TOTALES FORMULA
        var volFormula = totCant / (parseInt($('.densidad_objetivo').val()) * 1000);
        var vocTotales = totVocInd / volFormula;
        console.log('vocTotales',vocTotales, totVocInd,volFormula);
        var vocTotalesVal = Number.isNaN(vocTotales / 1000) ? 0 : (vocTotales / 1000).toFixed(4);
        $('.vocTotales').val(vocTotalesVal);

        volFormula = totCant / (parseInt($('.densidad_pesado').val()) * 1000);
        vocTotales = totVocInd / volFormula;
        vocTotalesVal = Number.isNaN(vocTotales / 1000) ? 0 : (vocTotales / 1000).toFixed(4);
        $('.vocTotalesP').val(vocTotalesVal);

        volFormula = totCant / (parseInt($('.densidad_teorico').val()) * 1000);
        vocTotales = totVocInd / volFormula;
        vocTotalesVal = Number.isNaN(vocTotales / 1000) ? 0 : (vocTotales / 1000).toFixed(4);
        $('.vocTotalesT').val(vocTotalesVal);

        $('.pesoTotal').val(totCant.toFixed(4));






        return false;
    }


    //$('.producto').change();








});
var append = false;

function calcularTotPinturas() {
    //_l('calcularTotPinturas');

    n = 2;
    for (var i in cant) {
        $('#porcentaje_teorico-' + n).trigger('blur', [true]);
        n++;
    }

}

function loading(status) {
    if (status) {
        $('.loader').show();

    } else {
        $('.loader').hide();
        $('.new-rows').show('slow');
        n = 2;
        for (var i in cant) {
            $('#cantidad_pesada-' + n).trigger('blur', [true]);
            n++;
        }


    }
}




