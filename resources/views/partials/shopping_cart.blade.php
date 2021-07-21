<section class="shopping-cart box">
                <div class="box-header">
                    <h2>Carrinho de Compras</h2>
                    <p>This is an example of Api Checkout of Cloudfox</p> 
                </div>
                <div class="box-content">
                    <div class="row">
                        <div class="col-md-12 col-lg-8 py-3">
                            <div class="row justify-content-md-center">
                                <div class="col-md-3">
                                    <img class="img-fluid mx-auto d-block image" src="img/product.jpg">
                                </div>
                                <div class="col-md-4">
                                    <h5 class="pt-4">Produto</h5>
                                    <div class="product-info">
                                        <p><b>Descrição: </b><span id="product-description">Produto de Teste </span><br>
                                        <b>Tamanho: </b>M<br>
                                        <b>Cor: </b>Verde<br>
                                        <b>Preço:</b> R$ <span id="unit-price">100</span></p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label for="quantity"  class="pt-4"><h5>Quantidade</h5></label>
                                    <input type="number" id="quantity" value="1" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-4 px-0">
                            <div class="summary">
                                <h3>Carrinho</h3>
                                <div class="summary-item">
                                    <span class="text">Subtotal</span><span class="price" id="cart-total"></span>
                                </div>
                                <div class="d-grid gap-2">
                                    <button class="btn btn-primary" id="checkout-btn">Continuar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>