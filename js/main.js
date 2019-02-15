let basketHeaderEl = document.querySelector('.basket');

let updateBasket = (productId = null)=>{
    let xhr = new XMLHttpRequest();
    let href = '/basket_handler.php';

    if( productId != null ){
        href += `?product_id=${productId}`;   
    }

    xhr.open('get', href);
    xhr.send();

    xhr.onreadystatechange = function(){
        if( xhr.readyState == 4 && xhr.status == 200 ){
            renderBasket( JSON.parse( xhr.responseText ) );
        }
    }
    
}

let renderBasket = (data)=>{
    basketHeaderEl.innerHTML = `
        Ваша корзина: (${data.basketInfo.count}) ${data.basketInfo.fullPrice} руб.
    `;
    
}

updateBasket();