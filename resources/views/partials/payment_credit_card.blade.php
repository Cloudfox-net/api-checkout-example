            <section class="payment-credit-card box">
                <div class="box-header">
                    <h2>Pagamento com Cartão de crédito</h2>
                    <p>This is an example of Api Checkout of Cloudfox</p> 
                    <div id="alertPaymentCC"></div>
                </div>
                <div class="box-content">
                    <form id="form-credit-card">                        
                        @csrf
                        <div class="row">
                            <div class="col-md-12 col-lg-8 py-3 px-5">
                                <div class="row">
                                    <div class="col-md-10">
                                        <div class="form-group">
                                            <label for="">Número do cartão de crédito</label>
                                            <input type="text" class="form-control" name="card_number" value="5545980854977869" required>
                                        </div>
                                    </div>
                                    <div class="col-md-2"></div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Nome impresso no cartão</label>
                                            <input type="text" class="form-control" name="card_name" value="APROVADO" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                        <label for="">Validade Cartão</label>
                                        <input type="text" class="form-control" name="card_expiration_date" value="10/2025" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                        <label for="">Cód. Segurança</label>
                                        <input type="text" class="form-control" name="card_cvv" value="123" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Parcelamento</label>
                                            <select name="installments" id="installments" class='form-control' required>
                                                <option value="">Selecione</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>                            
                                <br/>
                                <a href="#" class="link-danger go-to-back-pm" pm="credit-card">
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
                                        <button class="btn btn-primary btn-finish">Finalizar Compra</button>
                                    </div>
                                </div>
                            </div>
                        </div>  
                    </form>                  
                </div>
             
            </section> 