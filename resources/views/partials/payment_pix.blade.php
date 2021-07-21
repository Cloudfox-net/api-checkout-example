            <section class="payment-pix box">
                <div class="box-header">
                    <h2>Pagamento com Pix</h2>
                    <p>This is an example of Api Checkout of Cloudfox</p> 
                    <div id="alertPaymentPix"></div>
                </div>
                <div class="box-content">
                    <form id="form-pix">                        
                        @csrf
                        <div class="row">
                            <div class="col-md-12 col-lg-8 py-3 px-5">
                                <div class="text-center">
                                    <div id="qrcode_img">
                                        <img src="img/qr_code_example.png" class="rounded" alt="...">
                                    </div>
                                    <p>Se preferir, pague com a opção <strong>PIX Copia e Cola</strong>:</p>
                                    <input type="text" class="form-control" name="qr-code" id="qrcode" disabled>
                                </div>  
                                <br/> 
                                <a href="#" class="link-danger go-to-back-pm" pm="pix">
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
                    </div>          
                </div>
             
            </section>