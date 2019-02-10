// console.log('js подключен');
let catalogProductsEl = document.querySelector('.catalog-products');
let catalogPoginationEl = document.querySelector('.catalog-pagination');


let renderCatalog = (data) => {
    catalogProductsEl.innerHTML = '';
    catalogPoginationEl.innerHTML = '';
    data.products.forEach((productItem) => {
        let divProductEl = document.createElement('div');
        divProductEl.classList.add ('catalog-product-item');
        let img_src = 'default.jpeg';
        if (productItem.photo!=''){
            img_src = productItem.photo
        };
        divProductEl.innerHTML = `
            <img src='/images/catalog/${img_src}'>
            <div class='name'>${productItem.name}</div>
            <div class='price'>${productItem.price} руб.</div>
            <button data-id='${productItem.id}'>Добавить в корзину</button>`
        ;

        divProductEl.querySelector('button').addEventListener('click', function(){
            updateBasket(this.getAttribute('data-id'));
        });

        catalogProductsEl.append(divProductEl);
    });



    for (let i = 1; i <= data.pafinationInfo.countPage; i++){
        let divPagination = document.createElement('div');
        divPagination.classList.add ('catalog-pogination-item');
        divPagination.innerHTML = i;
        if (data.pafinationInfo.nowPage == i){
            divPagination.classList.add('active');
        }
        divPagination.setAttribute('data-page', i);
        divPagination.addEventListener('click',function(){
            updateCatalogFromAjax(this.getAttribute('data-page'));
        });
        catalogPoginationEl.append(divPagination);
    

    }
}

let updateCatalogFromAjax= (page = 1) => {
    let xhr = new XMLHttpRequest();
    xhr.open('get',`/catalog-handler.php?page=${page}`);
    xhr.send();
    xhr.onreadystatechange = ()=>{
        if(xhr.readyState == 4 && xhr.status == 200){
            renderCatalog (JSON.parse(xhr.responseText));
        }
    }
}
updateCatalogFromAjax(1);