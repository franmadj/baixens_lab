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
    $('[tabIndex="1"]').focus();


    var noProcesarAjax = true;
    $('#secciones').change(function () {
        //console.log($(this).val());
        if ($(this).val() == 1) {
            $('.enlucido-fields-act').removeClass('enlucido-fields');
            //codigo, cantidad, producto, enlucido
            $('#append tr').eq(1).find('.codigo').attr('tabindex', '19');
            $('#append tr').eq(1).find('.cantidad').attr('tabindex', '20');
            $('#append tr').eq(1).find('.producto').find('input[type="text"]').attr('tabindex', '21');
            $('#append tr').eq(1).find('.enlucido').attr('tabindex', '22');
            tabIndex = 22;
            index_ini = 19;

        } else {
            $('.enlucido-fields-act').addClass('enlucido-fields');
            $('#append tr').eq(1).find('.codigo').attr('tabindex', '16');
            $('#append tr').eq(1).find('.cantidad').attr('tabindex', '17');
            $('#append tr').eq(1).find('.producto').find('input[type="text"]').attr('tabindex', '18');
            $('#append tr').eq(1).find('.enlucido').attr('tabindex', '-1');
            tabIndex = 18;
            index_ini = 16;
        }
    });

    if ($('#secciones').val() == 1) {
        $('.enlucido-fields-act').removeClass('enlucido-fields');

    }
    $('#secciones').change();

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

    $('body').on('blur', '.codigo', function (e, isTriggered) {
        isTriggered = typeof isTriggered == 'undefined' ? false : isTriggered;
        console.log('.codigo', isTriggered);
//        console.log('isTriggered');
//        console.log(isTriggered);
        var id = $(e.currentTarget).attr('id');
        console.log(id);
        console.log('codigo-' + (filasDeMas + 1));
        var isLastRow = (id == 'codigo-' + (filasDeMas + 1));

        var val = $(this).val();
        //console.log(val);
        var $this = $(this);
        if (val == 0) {
            var $parent = $this.parent().parent();
            $parent.find('.coste').val('');
            $parent.find('.voc').val('');
            $parent.find('.vocIndividual').val('');
            $parent.find('.densidad').val('');
            $parent.find('.importe').val('');
            $parent.find('.producto').val(0);
            $parent.find('.codigo').val(0);
            $parent.find('.proveedor').val('');
            $parent.find('.proveedorNom').val('');
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
                //log(esBaseHija,availableProductCodes,availableProductCodes.indexOf(data.productoCode)==-1,!isTriggered);
                //log(esBaseHija);log(availableProductCodes);log(availableProductCodes.indexOf(data.id)==-1);log(!isTriggered);log(data.productoCode);
                if (esBaseHija && availableProductCodes.length && availableProductCodes.indexOf(data.id) == -1 && !isTriggered) {
                    bootbox.alert("El codigo introducido no corresponde a ningun color!");
                } else {

                    var $parent = $this.parent().parent();
                    $parent.find('.coste').val(data.coste);
                    $parent.find('.voc').val(data.voc);
                    //$parent.find('.vocIndividual').val(vocIndividual($parent.find('.densidad').val(), $parent.find('.cantidad').val());
                    $parent.find('.densidad').val(data.densidad);
                    $parent.find('.importe').val(parseFloat(data.coste) * parseFloat($parent.find('.cantidad').val()));

                    $parent.find('.producto').val(data.id);
                    $parent.find('.producto').parent().find('.select2-chosen').text(data.productoName);



                    $parent.find('.proveedorNom').val(data.proveedorNom);
                    calcularVocIndividual($parent.find('.voc'), $parent.find('.cantidad'), $parent.find('.densidad'), $parent.find('.vocIndividual'));
                    //will trigger cantidad blur event when add formulas base hija after product is set with ajax 
                    if (typeof $cantidad != 'undefined' && $cantidad.length) {
                        $cantidad.trigger("blur");
                    }

                    if (editando && isTriggered) {
                        if (isLastRow && !calculated && !esBaseHija) {
                            calculated = true;
                            calcular()
                            //                        setTimeout(function () {
                            //                            calcular()
                            //                        }, 1000);
                        } else if (esBaseHija) {
                            setTimeout(function () {
                                calcular()
                            }, 1000);
                        }
                    } else if (esNewBaseHija && isTriggered) {
                        setTimeout(function () {
                            calcularNewBaseHija()
                        }, 1000);
                    }
                }


            },
            dataType: 'json'
        });

        return false;
    });


    $('body').on('blur', '.cantidad', function () {
        $(this).data('val', $(this).val());
        var $parent = $(this).parent().parent();
        $parent.find('.importe').val(parseFloat($parent.find('.coste').val()) * parseFloat($parent.find('.cantidad').val()));
        calcularVocIndividual($parent.find('.voc'), $parent.find('.cantidad'), $parent.find('.densidad'), $parent.find('.vocIndividual'));
    });


//solo para cuando las filas de prouctos se rellenan con valores de php no js
    if (esBaseHija) {
        $('.codigo-color').each(function () {
            $cantidad = $(this).parent().parent().find('.cantidad-color');
            $(this).trigger("blur", [true]);

        });


    }

    $('.del-row').click(function () {
        jQuery(this).parent().parent().remove();
        numFilas = parseInt(jQuery('#filasDeMas').val());
        jQuery('#filasDeMas').val(numFilas - 1);
        reset_order_rows_table();
        $('#numComponentes').remove();
        return false;
    });
    $('.add-row').click(function (e) {
        aClonar = $('#aClonar').clone();
        numFilas++;
       
        addClon(numFilas, e, false);
        $('#numComponentes').remove();
        return false;
    });




    var aClonar;
    var desc = Array();
    var prevButton = Array();
    //var tabIndex=18;
    var top = false;
    /**
     * 
     * @param {type} posthe next index position  for names
     * @param {type} target row fromthe new row will be added
     * @returns {undefined}
     */
    function addClon(pos, target, automatic) { //return;
        //console.log(pos);
        jQuery('#filasDeMas').val(pos - 1);
        aClonar.removeAttr('id');
        aClonar.addClass('new-rows');
        //aClonar.show();
        var newSelectCodigos = selectCodigos.clone();
        if (aClonar.find('.color').length)
            aClonar.find('.color').attr('name', 'det-color-' + pos).attr('id', 'color-' + pos).val('1');

        aClonar.find('.codigo').attr('name', 'det-codigo-' + pos).attr('id', 'codigo-' + pos).val('');
        aClonar.find('.cantidad').attr('name', 'det-cantidad-' + pos).attr('id', 'cantidad-' + pos).val('');
        var newSelectProductos = selectProductos.clone();
        newSelectProductos.attr('id', 'producto-' + pos).attr('name', 'det-producto-' + pos).val('0');
        aClonar.find('.producto').parent().html(newSelectProductos);
        newSelectProductos.select2({
            placeholder: "Select an option",
            allowClear: true
        });
        if (aClonar.find('.enlucido').length)
            aClonar.find('.enlucido').attr('name', 'det-enlucido-' + pos).attr('id', 'enlucido-' + pos).val(0);
        aClonar.find('.proveedorNom').attr('name', 'det-proveedor-' + pos).attr('id', 'proveedorNom-' + pos).val('');
        aClonar.find('.densidad').attr('name', 'det-densidad-' + pos).attr('id', 'densidad-' + pos).val('');
        aClonar.find('.coste').attr('name', 'det-coste-' + pos).attr('id', 'coste-' + pos).val('');
        aClonar.find('.importe').attr('name', 'det-importe-' + pos).attr('id', 'importe-' + pos).val('');
        aClonar.find('.voc').attr('name', 'det-voc-' + pos).attr('id', 'voc-' + pos).val('').val('');
        aClonar.find('.vocIndividual').attr('name', 'det-vocIndividual-' + pos).attr('id', 'vocIndividual-' + pos).val('');

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
                $('#numComponentes').remove();
                return false;
            }
        });
        //botonMenos=boton;
        //prevButton[pos] = boton;
        aClonar.find('.boton').html(boton);

        var boton_mas = $('<button/>', {
            text: '+',
            class: 'btn green',
            style: 'padding:1px 14.5px;',
            type: "button",
            click: function (e) {
                aClonar = $('#aClonar').clone();
                numFilas++;
                addClon(numFilas, e, false);
                $('#numComponentes').remove();
                return false;
            }
        });
        aClonar.find('.boton').append(boton_mas);


        // jQuery('#aClonar').after(aClonar);

        if ($('.fila-apartir-colores').length) {//añade la siguiente fila despues de la marcada en base para meter colores
            $('.fila-apartir-colores').after(aClonar);
            $('.fila-apartir-colores').removeClass('fila-apartir-colores');
            aClonar.addClass('fila-apartir-colores fila-apartir');
        } else if (target.target) {//se especifica una fila cuando se hace click al boton mas
            //console.log($(target.target));
            new_target = $(target.target).parent().parent();
            new_target.after(aClonar);
        } else {//se añade la fila a continuacion de la ultima fila
            if (!append) {
                jQuery("#aClonar").after(aClonar);
            } else {
                jQuery("#append").append(aClonar);
            }
            append = false;
        }
        //automatic= se añadieron filas de forma automatica en el bucle for
        if (!automatic) {

            aClonar.show();
            reset_order_rows_table();
            aClonar.find('.codigo').focus();

        }



        if (top) {//solo cuando se añade fila y no cuando se borra
            top = false;
            $("html, body").animate({scrollTop: aClonar.offset().top - 200}, 1000);
        }
        //aClonar.find("td:first").find('.codigo').focus();
    }

    $('.plus-button').click(function (e) {
        aClonar = $('#aClonar').clone();
        numFilas++;
        addClon(numFilas, e, false);
        $('#numComponentes').remove();
        return false;
    });


    // reorderna los nombres de las campos cuando nueva fila es introducida para mantener el order cuando se guarde(no cuando se hace de forma automatica por el bucle)
    function reset_order_rows_table() {
        index = index_ini;

        $('#append tr').each(function (s) {
            var i = s + 1;
            var el = $(this);
            if (el.is(':visible')) {

                if (el.find('.td_color').length) {
                    el.find('.td_color').find('input').attr('name', 'det-color-' + i).attr('id', 'color-' + i);

                }
                el.find('.td_codigo').find('input').attr('tabindex', index).attr('name', 'det-codigo-' + i).attr('id', 'codigo-' + i);
                index++;
                console.log(index);
                el.find('.td_cantidad').find('input').attr('name', 'det-cantidad-' + i).attr('tabindex', index).attr('id', 'cantidad-' + i);
                index++;
                //console.log(index);
                el.find('.td_prod').find('.select2-focusser').attr('tabindex', index);
                el.find('.td_prod').find('select').attr('name', 'det-producto-' + i).attr('id', 'producto-' + i);

                if (el.find('.enlucido-fields-act').is(':visible')) {
                    index++;
                    //console.log(index);
                    el.find('.enlucido-fields-act').find('select').attr('name', 'det-enlucido-' + i).attr('tabindex', index).attr('id', 'enlucido-' + i);
                }
                index++;

            }

        });
        $('#enviar_formula').attr('tabindex', index);

    }
    $('#enviar_formula').click(function (e) {
        e.preventDefault();
        
        var errorProductos=false;
        var errorFormula=($('input[name="nombre"]').val()=='');
        $('tr.new-rows').each(function(el,i){
            $this=$(this);
            if(($this.find('.codigo').val()=='' || $this.find('select.producto').val()=='' || $this.find('.cantidad').val()=='') && ($this.find('.cantidad').val()!='' && $this.find('.codigo').val()!='0')){
                errorProductos=true;
                //console.log($this.find('.codigo').val()=='' , $this.find('select.producto').val()=='' , $this.find('select.tipo').val()=='' , $this.find('.porcentaje_teorico').val()=='');
            }
            
        });
        _l(errorFormula,errorProductos);
        if(errorProductos || errorFormula){
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
                        //console.log($(this).val());
                    });
                }
                if (editingBase) {
                    if (parseInt($('.pesoTotal').val()) != 100) {
                        editingBase = false;
                        $('#cantPorduccion').val(100);
                        $('#recalcular').trigger('click');

                        //alert('recalculado');
                    }
                }
                $('#formula_form').submit();
            } else {
                //return false;
            }



        });



    });



    var filasDeMas = parseInt(jQuery('#filasDeMas').val());



    var numFilas = 1 + filasDeMas;
    //var numCodig = {$numCodig};
    $('#uno-mas').click(function (e) {
        unoMas();


    });
    function unoMas() {
        aClonar = $('#aClonar').clone();
        numFilas++;
        $('#numComponentes').remove();
        addClon(numFilas, false, false);

    }
    $('body').on('keypress', window, function (event) {

        //jQuery(window).keypress(function(event){
        var key = event.which;
        //console.log(key);
        //+ 43
        //- 45
        if (key == 43) {
            //console.log($(document.activeElement));
            event.preventDefault();
            append = true;
            top = true;
            unoMas();
        } else if (key == 45) {
            //event.preventDefault();
            //$('#append tr:last').find('.boton').find('.red').click();
        }


    });



    n = 2;
    length = cant.length;

    for (var i in cant) {
        //console.log('cant'+i);
        if (typeof esColor != 'undefined' && typeof esColor[i] != 'undefined' && esColor[i] === '1') {
            $('#color-' + n).attr('checked', true);

        }
        $('#cantidad-' + n).val(cant[i]).data('val', cant[i]);
        if (typeof enlucido != 'undefined' && typeof enlucido[i] != 'undefined')
            jQuery('#enlucido-' + n).val(enlucido[i]);
        jQuery('#codigo-' + n).val(producto[i]).trigger('blur', [true]);
        if (length == (parseInt(i) + 1)) {


        }
        n++;
    }
    setTimeout(function () {
        loading(false);
    }, 500);
    //$('.producto').change();


    if (esBaseHija) {
        setTimeout(function () {
            calcular()
        }, 3000);
    }





});

function loading(status) {
    if (status) {
        $('.loader').show();
    } else {
        $('.loader').hide();
        $('.new-rows').show('slow');

    }
}
var append = false;


