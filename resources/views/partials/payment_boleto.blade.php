<section class="payment-boleto box">
                <div class="box-header">
                    <h2>Pagamento com Boleto</h2>
                    <p>This is an example of Api Checkout of Cloudfox</p> 
                    <div id="alertPaymentBo"></div>
                </div>
                <div class="box-content">
                    <form id="form-boleto">                        
                        @csrf
                        <div class="row">
                            <div class="col-md-12 col-lg-8 py-3 px-5">
                                <div class="row">
                                    <div class="col-12">
                                        <p class="obs">
                                            Os pagamentos efetuados via Boleto Bancário não podem ser parcelados. Seu produto será
                                            reservado e enviado <strong>somente após a confirmação do pagamento</strong> do boleto.
                                        </p>
                                        <p class="information"><strong>Lembre-se:</strong></p>
                                        <div class="alert alert-secondary" role="alert">
                                            <ul>
                                                <li>Você deve pagar seu boleto até a data de vencimento;</li>
                                                <li>O pagamento leva em torno de 2 dias úteis para ser processado;</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>        
                                <a href="#" class="link-danger go-to-back-pm" pm="boleto">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 10 10" class="chevron-left">
                                    <path fill="#ff4e05" fill-rule="nonzero"id="chevron_left" d="M7.05 1.4L6.2.552 1.756 4.997l4.449 4.448.849-.848-3.6-3.6z"></path>
                                    </svg>
                                    Voltar para tela anterior
                                </a>
                            </div>
                            <div class="col-md-12 col-lg-4 pl-0">
                                <div class="summary">
                                    <h3>Resumo</h3>
                                    <div class="summary-item">
                                        <p>
                                            <span class="text">Produto de teste x <span class="summary-quantity"></span> </span><span class="price summary-price"></span>
                                        </p>
                                        <p>
                                            <span class="text">Total</span><span class="price summary-total"></span>
                                        </p>
                                    </div>
                                    <div class="d-grid gap-2">
                                        <button type="submit" class="btn btn-primary btn-finish">Finalizar Compra</button>
                                    </div>
                                </div>
                            </div>
                        </div>    
                    </form>                
                </div>
             
            </section>