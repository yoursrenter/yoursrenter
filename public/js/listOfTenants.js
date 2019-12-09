class ListOfTenants {
    constructor() {
        this.init();
        this.handle();
    }

    init() {
        this.tableElem = document.querySelector('.table-sort');
    }

    handle() {
        this.tableElem.addEventListener('click', () => {
            let elem = event.target;
            let parentId = elem.parentElement.id;

            this.toggleElem(parentId);
            this.toInputInfo(elem);

            this.getNumberElem(elem);
        });

    }

    toggleElem(id) {
        console.log(id);
        const captionElem = document.getElementById(id + '_info_caption');
        const infoElem = document.getElementById(id + '_info_text');
        captionElem.classList.toggle('table__content_hide');
        infoElem.classList.toggle('table__content_hide');
    }

    toInputInfo(elem) {
        if (!elem.className.indexOf('table__content_info')) {
            this.elemToInput(elem);
        } else if (!elem.className.indexOf('table__content_input')) {
            this.elemToInfo(elem);
        }
    }

    getNumberElem(elem) {
        // todo функция помогающая отыскать тип данных, которые были изменены
    }

    elemToInput(elem) {
        if (elem.textContent !== '') {
            const value = elem.textContent;
            elem.innerHTML = `<input type="input" class="table__content_input" value="${value}">`;
        }
    }

    elemToInfo(elem) {
        const value = elem.value;
        elem.parentElement.innerHTML = value;

        // todo обязательно сделать запоминалку (того, какие данные были изменены)
        //  для отправки на сервер, чтобы система могла обновить данные в базе
    }
}

const listOfTenants = new ListOfTenants();