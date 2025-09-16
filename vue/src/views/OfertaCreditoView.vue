<script setup>
import Loader from '@/components/Loader.vue';
import http from '@/service/http';
import { reactive } from 'vue';

import {Fluid, InputText, Button, DataTable,Column} from 'primevue';

document.title = 'Listagem de crédito';
const errors = reactive({'errors': []});
const ofertas = reactive({ofertas: []});
const loading = ref(false);
function maskOfertas(){
    ofertas.ofertas.forEach(oferta => {
        oferta.parcelaMensal = formataMoeda(calculaParcela(oferta.valorSolicitado, oferta.taxaJuros, oferta.qntParcelas));
        oferta.valorAPagar = formataMoeda(oferta.valorAPagar);
        oferta.valorSolicitado = formataMoeda(oferta.valorSolicitado)
        oferta.taxaJuros = Number(oferta.taxaJuros*100).toFixed(2).replace('.',',')+'% a.m';
        
    });
}
function calculaParcela(valor, jurosMes, parcelas){
    let cf = jurosMes / (1 - (1 / Math.pow(1 + jurosMes, parcelas)));
	return (cf * valor);
}
function formataMoeda(valor){
	return 'R$ '+Number(valor).toFixed(2).replace('.',',').replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}
function buscarOfertas(){
    event.preventDefault();
    const formData = new FormData(document.getElementById('form'));
	loading.value = true;
    errors.errors = [];
    ofertas.ofertas = [];
    http.post('getOfertas', formData).then(response => {
        if(response.data.length == 0){
            ofertas.ofertas = null;
        }else{
            ofertas.ofertas = response.data.ofertas;
            maskOfertas();
        }
        loading = false;
        
    }).catch(error => {
        if(error.status == 502){
            
            toast.add({
                severity: 'error',
                summary: 'Alerta',
                detail: 'Não foi possível completar a solicitação',
            });
        }
        if(error.response.data.errors)
        {
            errors.errors = error.response.data.errors;
        }
        if(error.status == 404){
            ofertas.ofertas= null;
            
        }else{
            ofertas.ofertas= [];
        }
        loading = false;
    });
}

</script>
<template>
    <div class="grid grid-cols-12 gap-8" style="width: 1100px;">
        <form class="col-span-12 xl:col-span-12" v-on:submit="buscarOfertas" id="form">
            <div class="card flex flex-col gap-4 w-full grid" >
                <h1>Consulta de crédito</h1>
                <Fluid class="flex flex-wrap flex-col items-start gap-4"style="display: flex;flex-flow: wrap;flex-direction: row;    align-items: flex-end;    gap: 8px;">
                    <div class="flex flex-col col-span-4 md:flex-row gap-4"  style="width: 200px;">
                        <div class="flex flex-wrap gap-2 w-full">
                            <label for="id_servico">CPF*</label>
                            <InputText style="margin-top: 5px;" id="cpf" optionLabel="cpf"  name="cpf" placeholder="Insira o CPF" />
                        </div>
                    </div>
                    <div style="flex:1">
                        <Button type="submit" style="width:200px">Pesquisar</Button>
                    </div>
                </Fluid>
                <div>
                    <em v-if="errors.errors.cpf" class="error">{{ errors.errors.cpf[0] }}</em>
                </div>
             
            </div>
        </form>
    </div>
    
        <div  class="card" style="margin-top: 20px;" v-if="ofertas.ofertas != null &&  ofertas.ofertas.length > 0">
            <h1>Ofertas</h1> 
            <label>Os resultados a seguir foram ordenados pelo menor valor de mensalidade usando o maior valor disponível de crédito</label>
            <template v-if="ofertas.ofertas && ofertas.ofertas.length > 0">
                <DataTable :value="ofertas.ofertas" stripedRows  scrollable scrollHeight="400px" class="mt-6" style="margin-top: 20px">
                    <Column field="instituicaoFinanceira" header="Instituição Financeira" style="min-width: 250px" class="font-bold"></Column>
                    <Column field="modalidadeCredito" header="Modalidade de crédito" style="min-width: 125px" class="font-bold"></Column>
                    <Column field="valorAPagar" header="Valor à pagar" style="min-width: 125px" class="font-bold"></Column>
                    <Column field="valorSolicitado" header="Valor solicitado" style="min-width: 125px" class="font-bold"></Column>
                    <Column field="taxaJuros" header="Taxa de Juros" style="min-width: 125px" class="font-bold"></Column>
                    <Column field="qntParcelas" header="Qtd. Parcelas" style="min-width: 125px" class="font-bold"></Column>
                    <Column field="parcelaMensal" header="Parcela mensal" style="min-width: 125px" class="font-bold"></Column>
                </DataTable>
            </template>
        
        </div>
        <template v-else-if="loading">
            <Loader/>
        </template>
        <template v-else-if="ofertas.ofertas == null">
            <div  class="card" style="margin-top: 20px;">
                <h5 style="text-align: center;">Não foram encontradas ofertas para o CPF informado</h5> 
            </div>
        </template>
  
</template>  
<style scoped>
.error{
    color:#FF6961;
}
.bounce-item-enter-active {
  animation: bounce-in 1s ;
  animation-fill-mode: backwards;
}
.bounce-leave-from, .bounce-item-leave-active {
    display: none;
}
@keyframes bounce-in {
  0% {
    transform: scale(0);
  }
  50% {
    transform: scale(1.1);
  }
  100% {
    transform: scale(1);
  }
}
@keyframes bounce-out {
  0% {
    transform: scale(1);
  }

  100% {
    transform: scale(1);
  }
}
</style>