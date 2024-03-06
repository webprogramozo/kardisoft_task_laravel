import './bootstrap';
import {Modal} from 'bootstrap';
import $ from 'jquery';
import _ from 'lodash';

$(function(){
    const loader_modal = $('#med_loader_modal');
    function setMedLoadState(state){loader_modal.attr('data-state', state);}
    $('#med_loader_button').click(function(){
        setMedLoadState('waiting');
        const modal = new Modal(loader_modal[0]);
        modal.show();
        setTimeout(async function(){
            let options = {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    _token: document.getElementsByName('_token')[0].value
                })
            }
            try {
                let p = await fetch('/load-meds', options);
                let response = await p.json();
                $("#med_all_count").text(response.item_count);
                $("#med_error_count").text(response.error_count);
                setMedLoadState('success');
            }catch(e){
                setMedLoadState('failure');
            }
        }, 300);
    });
    //handling the search bar
    $('#searchbar').on('keyup', _.debounce(async function(){
        let maxLength = 0;
        const qStr = this.value.split(' ').filter(function(item){
            maxLength = Math.max(item.length, maxLength);
            return item.length;
        });
        if(maxLength >= 3) {
            let options = {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    qstr: qStr,
                    _token: document.getElementsByName('_token')[0].value
                })
            }
            let p = await fetch('/search', options);
            let response = await p.json();
            document.getElementById('resultset').innerHTML = '';
            response.forEach(function(i){
                $(`<tr data-id="${i.med_id}" class="result-item"><td>${i.med_name} <a class="info-button">🛈</a></td></tr>`).appendTo('#resultset').find('a').click(function(){
                    document.getElementById('med_name_label').innerText = i.med_name;
                    document.getElementById('med_reg_number_label').innerText = i.med_reg_number;
                    document.getElementById('med_active_ingredient_label').innerText = i.med_active_ingredient;
                    document.getElementById('med_atc_code_label').innerText = i.med_atc_code;
                    document.getElementById('med_auth_date_label').innerText = i.med_auth_date;
                    (new Modal('#med_info_modal', {})).show();
                });
            });

        }
    }, 300, {trailing: true, maxWait: 800, leading: true}));
});
