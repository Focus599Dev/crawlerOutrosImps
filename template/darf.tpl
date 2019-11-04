
<style>
	.border-full{
		border: 1px solid #000;
	}

	.border-left{
		border-left: 1px solid #000;
	}

	.border-right{
		border-right: 1px solid #000;
	}

	.border-top{
		border-top: 1px solid #000;
	}

	.border-bottom{
		border-bottom: 1px solid #000;
	}
	table{
		border: 0;
		border-collapse: collapse;
	}

	body{
		padding: 5px;
		margin: 0px;
		font-family: Arial, Helvetica, sans-serif;
	}
</style>
	
<p style="font-weight: bold;font-size: 8px">Aprovado pela IN/RFB nº 736/07</p>

<table style="width: 680px;">
	<tr>
		<td class="border-full" style="width: 342px">
			<table style="width: 342px" class="border-bottom">
				<tr>
					<td style="vertical-align: baseline;">
						<img src="{{%logo}}" width="65" />
					</td>

					<td>
						<table>
							<tr>
								<td style="font-size: 16px; font-weight: bold; padding-top:10px;">
									MINISTÉRIO DA FAZENDA
								</td>
							</tr>
							<tr>
								<td style="font-size: 11px; font-weight: bold;padding-top:15px;">
									SECRETARIA DA RECEITA FEDERAL DO BRASIL
								</td>
							</tr>
							<tr>
								<td style="font-size: 10px; font-weight: bold;padding-top:15px;">
									Documento de Arrecada&ccedil;&atilde;o de Receitas Federais
								</td>
							</tr>
							<tr>
								<td style="font-size: 16px; font-weight: bold; height: 70px;">
									DARF
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			<table style="width: 342px" class="border-bottom border-top">
				<tr>
					<td style="height: 31px;font-size: 10px;">
						<span style="height: 31px;font-size: 14px;font-weight: bold;">1</span>
						<span style="position: relative;font-size: 10px;font-weight: normal; vertical-align: baseline;;top: -3px">NOME / TELEFONE </br></span>
						{{%nome}}
					</td>
				</tr>
			</table>
			<table style="width: 342px">
				<tr>
					<td style="font-size: 12px;font-weight: bold; padding-left: 25px;">
						DARF válido para pagamento até {{%date_valid}}
					</td>
				</tr>

				<tr>
					<td style="font-size: 9px;font-weight: normal;padding-left: 25px;">
						Domicílio tributário informado: {{%municio}}
					</td>
				</tr>

				<tr>
					<td style="font-size: 12px;font-weight: bold; padding-left: 25px;">
						N&Atilde;O RECEBER COM RASURAS
					</td>
				</tr>

			</table>
			<table style="width: 342px">
				<tr>
					<td style="height: 100px; font-size: 8px;font-weight: bold; vertical-align: bottom;text-align: left;">
						SicalcWeb vers&atilde;o 1.7.66.7107
					</td>
					<td style="height: 100px; font-size: 8px;font-weight: bold; vertical-align: bottom;text-align: right;">
						{{%date_now}}
					</td>
				</tr>
			</table>
		</td>
		<td class="border-full" style="width: 341px">
			<table style="width: 341px">
				<tr>
					<td style="height: 31px;" class="border-right border-bottom">
						<span style="height: 31px;font-size: 14px;font-weight: bold;">2</span>
						<span style="position: relative;font-size: 10px;font-weight: normal; vertical-align: baseline;;top: -3px">PERÍODO DE APURA&Ccedil;&Atilde;O</span>
					</td>
					<td style="text-align: right;" class="border-bottom">
						<span style="height: 31px;font-size: 14px;font-weight: bold;position: relative;top: -9px">{{%date_apur}}</span>
					</td>
				</tr>
				
				<tr>
					<td style="height: 31px;" class="border-right border-bottom border-bottom">
						<span style="height: 31px;font-size: 14px;font-weight: bold;">3</span>
						<span style="position: relative;font-size: 10px;font-weight: normal; vertical-align: baseline;;top: -3px">NÚMERO DO CPF OU CNPJ</span>
					</td>
					<td style="text-align: right;" class="border-bottom">
						<span style="height: 31px;font-size: 14px;font-weight: bold;position: relative;top: -9px">{{%cnpj}}</span>
					</td>
				</tr>
				
				<tr>
					<td style="height: 31px;" class="border-right border-bottom">
						<span style="height: 31px;font-size: 14px;font-weight: bold;">4</span>
						<span style="position: relative;font-size: 10px;font-weight: normal; vertical-align: baseline;;top: -3px">CÓDIGO DA RECEITA</span>
					</td>
					<td style="text-align: right;" class="border-bottom">
						<span style="height: 31px;font-size: 14px;font-weight: bold;position: relative;top: -9px">{{%receita}}</span>
					</td>
				</tr>

				<tr>
					<td style="height: 31px;" class="border-right border-bottom">
						<span style="height: 31px;font-size: 14px;font-weight: bold;">5</span>
						<span style="position: relative;font-size: 10px;font-weight: normal; vertical-align: baseline;;top: -3px">NÚMERO DE REFERÊNCIA</span>
					</td>
					<td style="text-align: right;" class="border-bottom">
						<span style="height: 31px;font-size: 14px;font-weight: bold;position: relative;top: -9px">{{%referencia}}</span>
					</td>
				</tr>

				<tr>
					<td style="height: 31px;" class="border-right border-bottom">
						<span style="height: 31px;font-size: 14px;font-weight: bold;">6</span>
						<span style="position: relative;font-size: 10px;font-weight: normal; vertical-align: baseline;;top: -3px">DATA DE VENCIMENTO</span>
					</td>
					<td style="text-align: right;" class="border-bottom">
						<span style="height: 31px;font-size: 14px;font-weight: bold;position: relative;top: -9px">{{%vencimento}}</span>
					</td>
				</tr>


				<tr>
					<td style="height: 31px;" class="border-right border-bottom">
						<span style="height: 31px;font-size: 14px;font-weight: bold;">7</span>
						<span style="position: relative;font-size: 10px;font-weight: normal; vertical-align: baseline;;top: -3px">VALOR PRINCIPAL</span>
					</td>
					<td style="text-align: right;" class="border-bottom">
						<span style="height: 31px;font-size: 14px;font-weight: bold;position: relative;top: -9px">{{%valor_principal}}</span>
					</td>
				</tr>
				
				<tr>
					<td style="height: 31px;" class="border-right border-bottom">
						<span style="height: 31px;font-size: 14px;font-weight: bold;">8</span>
						<span style="position: relative;font-size: 10px;font-weight: normal; vertical-align: baseline;;top: -3px">VALOR DA MULTA</span>
					</td>
					<td style="text-align: right;" class="border-bottom">
						<span style="height: 31px;font-size: 14px;font-weight: bold;position: relative;top: -9px">{{%valor_multa}}</span>
					</td>
				</tr>
				
				<tr>
					<td style="height: 31px;" class="border-right border-bottom">
						<span style="height: 31px;font-size: 14px;font-weight: bold;">9</span>
						<span style="position: relative;font-size: 10px;font-weight: normal; vertical-align: baseline;;top: -3px">VALOR DOS JUROS E/OU </br> ENCARGOS DL - 1025/69</span>
					</td>
					<td style="text-align: right;" class="border-bottom">
						<span style="height: 31px;font-size: 14px;font-weight: bold;position: relative;top: -9px">{{%valor_juros}}</span>
					</td>
				</tr>
				
				<tr>
					<td style="height: 31px;" class="border-right border-bottom">
						<span style="height: 31px;font-size: 14px;font-weight: bold;">10</span>
						<span style="position: relative;font-size: 10px;font-weight: normal; vertical-align: baseline;;top: -3px">VALOR TOTAL</span>
					</td>
					<td style="text-align: right;" class="border-bottom">
						<span style="height: 31px;font-size: 14px;font-weight: bold;position: relative;top: -9px">{{%valor_total}}</span>
					</td>
				</tr>
				
				<tr>
					<td colspan="2" style="height: 54px;">
						<span style="height: 54px;font-size: 14px;font-weight: bold;">11</span>
						<span style="position: relative;top: -3px;font-size: 10px;font-weight: normal; vertical-align: baseline;">AUTENTICA&Ccedil;&Atilde;O BANCÁRIA (Somente nas 1 e 2 vias)</span>
					</td>
				</tr>
				
			</table>
		</td>
	</tr>
</table>

<hr style="border-top: 1px dashed #000; width: 705px;float: left;">

</br>

<p style="font-weight: bold;font-size: 8px; display: block;">Aprovado pela IN/RFB nº 736/07</p>

<table style="width: 680px;">
	<tr>
		<td class="border-full" style="width: 342px">
			<table style="width: 342px" class="border-bottom">
				<tr>
					<td style="vertical-align: baseline;">
						<img src="{{%logo}}" width="65" />
					</td>

					<td>
						<table>
							<tr>
								<td style="font-size: 16px; font-weight: bold; padding-top:10px;">
									MINISTÉRIO DA FAZENDA
								</td>
							</tr>
							<tr>
								<td style="font-size: 11px; font-weight: bold;padding-top:15px;">
									SECRETARIA DA RECEITA FEDERAL DO BRASIL
								</td>
							</tr>
							<tr>
								<td style="font-size: 10px; font-weight: bold;padding-top:15px;">
									Documento de Arrecada&Ccedil;&atilde;o de Receitas Federais
								</td>
							</tr>
							<tr>
								<td style="font-size: 16px; font-weight: bold; height: 70px;">
									DARF
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			<table style="width: 342px" class="border-bottom border-top">
				<tr>
					<td style="height: 31px;font-size: 10px;">
						<span style="height: 31px;font-size: 14px;font-weight: bold;">1</span>
						<span style="position: relative;font-size: 10px;font-weight: normal; vertical-align: baseline;;top: -3px">NOME / TELEFONE </br> </span>
						{{%nome}}
					</td>
				</tr>
			</table>
			<table style="width: 342px">
				<tr>
					<td style="font-size: 12px;font-weight: bold; padding-left: 25px;">
						DARF válido para pagamento até {{%date_valid}}
					</td>
				</tr>

				<tr>
					<td style="font-size: 9px;font-weight: normal;padding-left: 25px;">
						Domicílio tributário informado: {{%municio}}
					</td>
				</tr>

				<tr>
					<td style="font-size: 12px;font-weight: bold; padding-left: 25px;">
						N&Atilde;O RECEBER COM RASURAS
					</td>
				</tr>

			</table>
			<table style="width: 342px">
				<tr>
					<td style="height: 100px; font-size: 8px;font-weight: bold; vertical-align: bottom;text-align: left;">
						SicalcWeb vers&atilde;o 1.7.66.7107
					</td>
					<td style="height: 100px; font-size: 8px;font-weight: bold; vertical-align: bottom;text-align: right;">
						{{%date_now}}
					</td>
				</tr>
			</table>
		</td>
		<td class="border-full" style="width: 341px">
			<table style="width: 341px">
				<tr>
					<td style="height: 31px;" class="border-right border-bottom">
						<span style="height: 31px;font-size: 14px;font-weight: bold;">2</span>
						<span style="position: relative;font-size: 10px;font-weight: normal; vertical-align: baseline;;top: -3px">PERÍODO DE APURA&Ccedil;&Atilde;O</span>
					</td>
					<td style="text-align: right;" class="border-bottom">
						<span style="height: 31px;font-size: 14px;font-weight: bold;position: relative;top: -9px">{{%date_apur}}</span>
					</td>
				</tr>
				
				<tr>
					<td style="height: 31px;" class="border-right border-bottom border-bottom">
						<span style="height: 31px;font-size: 14px;font-weight: bold;">3</span>
						<span style="position: relative;font-size: 10px;font-weight: normal; vertical-align: baseline;;top: -3px">NÚMERO DO CPF OU CNPJ</span>
					</td>
					<td style="text-align: right;" class="border-bottom">
						<span style="height: 31px;font-size: 14px;font-weight: bold;position: relative;top: -9px">{{%cnpj}}</span>
					</td>
				</tr>
				
				<tr>
					<td style="height: 31px;" class="border-right border-bottom">
						<span style="height: 31px;font-size: 14px;font-weight: bold;">4</span>
						<span style="position: relative;font-size: 10px;font-weight: normal; vertical-align: baseline;;top: -3px">CÓDIGO DA RECEITA</span>
					</td>
					<td style="text-align: right;" class="border-bottom">
						<span style="height: 31px;font-size: 14px;font-weight: bold;position: relative;top: -9px">{{%receita}}</span>
					</td>
				</tr>

				<tr>
					<td style="height: 31px;" class="border-right border-bottom">
						<span style="height: 31px;font-size: 14px;font-weight: bold;">5</span>
						<span style="position: relative;font-size: 10px;font-weight: normal; vertical-align: baseline;;top: -3px">NÚMERO DE REFERÊNCIA</span>
					</td>
					<td style="text-align: right;" class="border-bottom">
						<span style="height: 31px;font-size: 14px;font-weight: bold;position: relative;top: -9px">{{%referencia}}</span>
					</td>
				</tr>

				<tr>
					<td style="height: 31px;" class="border-right border-bottom">
						<span style="height: 31px;font-size: 14px;font-weight: bold;">6</span>
						<span style="position: relative;font-size: 10px;font-weight: normal; vertical-align: baseline;;top: -3px">DATA DE VENCIMENTO</span>
					</td>
					<td style="text-align: right;" class="border-bottom">
						<span style="height: 31px;font-size: 14px;font-weight: bold;position: relative;top: -9px">{{%vencimento}}</span>
					</td>
				</tr>


				<tr>
					<td style="height: 31px;" class="border-right border-bottom">
						<span style="height: 31px;font-size: 14px;font-weight: bold;">7</span>
						<span style="position: relative;font-size: 10px;font-weight: normal; vertical-align: baseline;;top: -3px">VALOR PRINCIPAL</span>
					</td>
					<td style="text-align: right;" class="border-bottom">
						<span style="height: 31px;font-size: 14px;font-weight: bold;position: relative;top: -9px">{{%valor_principal}}</span>
					</td>
				</tr>
				
				<tr>
					<td style="height: 31px;" class="border-right border-bottom">
						<span style="height: 31px;font-size: 14px;font-weight: bold;">8</span>
						<span style="position: relative;font-size: 10px;font-weight: normal; vertical-align: baseline;;top: -3px">VALOR DA MULTA</span>
					</td>
					<td style="text-align: right;" class="border-bottom">
						<span style="height: 31px;font-size: 14px;font-weight: bold;position: relative;top: -9px">{{%valor_multa}}</span>
					</td>
				</tr>
				
				<tr>
					<td style="height: 31px;" class="border-right border-bottom">
						<span style="height: 31px;font-size: 14px;font-weight: bold;">9</span>
						<span style="position: relative;font-size: 10px;font-weight: normal; vertical-align: baseline;;top: -3px">VALOR DOS JUROS E/OU </br> ENCARGOS DL - 1025/69</span>
					</td>
					<td style="text-align: right;" class="border-bottom">
						<span style="height: 31px;font-size: 14px;font-weight: bold;position: relative;top: -9px">{{%valor_juros}}</span>
					</td>
				</tr>
				
				<tr>
					<td style="height: 31px;" class="border-right border-bottom">
						<span style="height: 31px;font-size: 14px;font-weight: bold;">10</span>
						<span style="position: relative;font-size: 10px;font-weight: normal; vertical-align: baseline;;top: -3px">VALOR TOTAL</span>
					</td>
					<td style="text-align: right;" class="border-bottom">
						<span style="height: 31px;font-size: 14px;font-weight: bold;position: relative;top: -9px">{{%valor_total}}</span>
					</td>
				</tr>
				
				<tr>
					<td colspan="2" style="height: 54px;">
						<span style="height: 54px;font-size: 14px;font-weight: bold;">11</span>
						<span style="position: relative;top: -3px;font-size: 10px;font-weight: normal; vertical-align: baseline;">AUTENTICA&Ccedil;&Atilde;O BANCÁRIA (Somente nas 1 e 2 vias)</span>
					</td>
				</tr>
				
			</table>
		</td>
	</tr>
</table>
