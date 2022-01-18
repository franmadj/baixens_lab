/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var index_ini;
jQuery(document).ready(function ($) {


    $('body').on('blur', '.codigo', function () {
        var val = $(this).val();
        console.log('val');
        console.log(val);
        var $this = $(this);
        if (val == 0) {
            var $parent = $this.parent().parent();
            $parent.find('.coste').val('');
            $parent.find('.productoName').val('');
            $parent.find('.importe').val('');
            $parent.find('.porcentaje').val('');

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
                var $parent = $this.parent().parent();
                $parent.find('.coste').val(data.coste);
                $parent.find('.importe').val((data.coste * $parent.find('.cantidad').val()).toFixed(2));
                $parent.find('.productoName').val(data.productoName);


            },
            dataType: 'json'
        });
        return false;

    });

    function reset_porcentajes() {
        var totCant = 0;
        $('.added').find('.cantidad').each(function () {
            var cantidad = parseFloat($(this).val());
            if (isNaN(cantidad))
                cantidad = 0;
            totCant += cantidad;
        });

        if (totCant < 1 || isNaN(totCant)) {
            calculoOk = false;
            return false;
        }
        $('.added').find('.cantidad').each(function () {
            $(this).parent().parent().find('.porcentaje').val(calcularPorcentaje($(this), totCant).toFixed(2));
        });

        return totCant;
    }

    $(document).on('blur', '.cantidad', function () {
        var $parent = $(this).parent().parent();
        $parent.find('.importe').val($(this).val() * $parent.find('.coste').val());
        reset_porcentajes();
    });


    $('#calcular').click(function () {
        calcular()
    });

    function calcular() {
        var totCant = importeTot = 0;
        totCant = reset_porcentajes();
        if (totCant === false)
            return false;

        $('.added').find('.importe').each(function () {
            var importe = parseFloat($(this).val());
            if (importe)
                importeTot += importe;
            _l('importeTot');
            _l($(this).val());
        });
        if (importeTot < 1 || isNaN(importeTot)) {
            calculoOk = false;
            return false;
        }
        $('.importeTotal').val(importeTot);
        $('.pesoTotal').val(totCant);
        $('.precioXkg').val((importeTot / totCant).toFixed(2));
        calculoOk = true;
        return false;

    }




    $('.send-formula').click(function (e) {
        e.preventDefault();
        $('#calcular').click();
        if (!$('#nombre').val().length) {
            calculoOk = false;
        }
        if (calculoOk) {
            if ($(this).attr('id') == 'guardar') {
                $('#general-form').removeAttr('target');
                $('#printing').remove();
            } else if ($(this).attr('id') == 'print') {
                $('#general-form').attr('target', '_blank').append('<input type="hidden" value="1" id="printing" name="printing">');
            }
            if (confirm('Deseas ejecutar la acción?'))
                $('#general-form').submit();
        } else {
            bootbox.alert('Rellena correctamente la formula antes de enviarla');
        }
    });





    var aClonar;
    var desc = Array();

    var tabIndex = 4;

    function addClon(pos, target) {
        jQuery('#filasDeMas').val(pos - 1);
        aClonar.removeAttr('id');
        aClonar.addClass('added');
        aClonar.show();

        aClonar.find('.codigo').attr('name', 'det-codigo-' + pos).attr('id', 'codigo-' + pos).val('');

        aClonar.find('.cantidad').attr('name', 'det-cantidad-' + pos).attr('id', 'cantidad-' + pos).val('');

        aClonar.find('.productoName').attr('name', 'det-productoName-' + pos).attr('id', 'productoName-' + pos).val('');

        aClonar.find('.coste').attr('name', 'det-coste-' + pos).attr('id', 'coste-' + pos).val('');
        aClonar.find('.porcentaje').attr('name', 'det-porcentaje-' + pos).attr('id', 'porcentaje-' + pos).val('');
        aClonar.find('.importe').attr('name', 'det-importe-' + pos).attr('id', 'importe-' + pos).val('');

        var boton = $('<button/>', {
            text: '*',
            class: 'btn red clickeable-menos',
            style: 'padding:1px 16px;',
            type: "button",
            click: function () {
                //if(prevButton[pos-1]){ prevButton[pos-1].css('display','inherit').addClass('clickeable-menos'); botonMenos=prevButton[pos-1];}
                jQuery(this).parent().parent().remove();
                numFilas = parseInt(jQuery('#filasDeMas').val());
                jQuery('#filasDeMas').val(numFilas - 1);
                reset_porcentajes();
                return false;
            }
        });
        //botonMenos=boton;
        //prevButton[pos] = boton;
        aClonar.find('.boton').html(boton);

        var boton_mas = $('<button/>', {
            text: '+',
            class: 'btn green',
            style: 'padding:1px 16px;',
            type: "button",
            click: function (e) {


                aClonar = $('#aClonar').clone();
                numFilas++;
                addClon(numFilas, e);
                return false;
            }
        });
        aClonar.find('.boton').append(boton_mas);


        // jQuery('#aClonar').after(aClonar);
        if (target.target) { //when clicking in plus row
            new_target = $(target.target).parent().parent();
            new_target.after(aClonar);
        } else {
            if (!append) {
                jQuery("#aClonar").after(aClonar);
            } else {
                jQuery("#append").append(aClonar);
            }
            append = false;
        }
        reset_order_rows_table();
        if (top) {
            top = false;

            $("html, body").animate({scrollTop: $(document).height()}, 1000);
        }
        aClonar.find("td:first").find('.codigo').focus();



    }

    function reset_order_rows_table() {
        index = 3;

        $('#append tr').each(function (s) {
            var i = s + 1;
            if ($(this).is(':visible')) {
//               console.log($(this));
//               console.log($(this).find('.td_codigo'));
//               console.log($(this).find('.td_codigo').find('.select2-focusser'));
//               console.log($(this).find('.td_codigo').find('select'));

                //console.log(index);
                $(this).find('.td_codigo').find('input').attr('tabindex', index).attr('name', 'det-codigo-' + i);
                index++;
                //console.log(index);
                $(this).find('.td_cantidad').find('input').attr('name', 'det-cantidad-' + i).attr('tabindex', index);
                index++;
                //console.log(index);
                $(this).find('.td_prod').find('.select2-focusser').attr('tabindex', index);
                $(this).find('.td_prod').find('select').attr('name', 'det-producto-' + i);

                if ($(this).find('.enlucido-fields-act').is(':visible')) {
                    index++;
                    //console.log(index);
                    $(this).find('.enlucido-fields-act').find('select').attr('name', 'det-enlucido-' + i).attr('tabindex', index);
                }
                index++;

            }

        });
        $('#guardar').attr('tabindex', index);

    }


    var filasDeMas = parseInt(jQuery('#filasDeMas').val());



    var numFilas = filasDeMas;
    //var numCodig = {$numCodig};
    $('#uno-mas').click(function () {
        aClonar = $('#aClonar').clone();
        numFilas++;
        addClon(numFilas, false);
    });

    $('body').on('keypress', window, function (event) {

        //jQuery(window).keypress(function(event){
        var key = event.which;
        //console.log(key);
        //+ 43
        //- 45
        if (key == 43) {

            event.preventDefault();
            append = true;
            top = true;
            reset_porcentajes();
            $('#uno-mas').click();
        } else if (key == 42) {
            event.preventDefault();
            $('#append tr:last').find('.boton').find('.red').click();
        }


    });




    if (filasDeMas > 0) {
        for (var i = 0; i < filasDeMas; i++) {
            append = true;
            aClonar = jQuery('#aClonar').clone();
            addClon(2 + i, false);
        }
    }
    var n = 2;

    for (var i in cant) {
        console.log('nuevo');

        jQuery('#codigo-' + n).val(codigo[i]).blur();

        $('#cantidad-' + n).val(cant[i]).blur();
        n++;
    }


    if (cant.length > 0) {
        setTimeout(function () {
            calcular();
        }, 700);

    }
    var append = false;









});


