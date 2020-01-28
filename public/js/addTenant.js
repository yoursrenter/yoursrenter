class AddTenant {
    constructor() {
        this.init();
        this.handle();
    }

    init() {
        this.data = [];
        this.addFormElem = document.getElementById('addTenantForm');
        this.sendFormElem = document.getElementById('sendForm');
        this.addButtonElem = document.getElementById('button_add_tenant');
        this.inputElems = this.addFormElem.querySelectorAll('input[type=text]');
        this.errorInputNames = [];
    }

    setDataParam(el) {
        this.data[el.name] = el.value;
    }

    // парсинг и валидация
    parse() {
        let condition = '';
        let message = '';
        this.inputElems.forEach(el => {
            switch (el.name) {
                case 'tenant_name':
                    condition = '!el.value.length';
                    message = 'поле не должно быть пустым';
                    break;
                case 'contact_fio':
                    condition = '!el.value.length';
                    message = 'поле не должно быть пустым';
                    break;
                case 'tenant_phone':
                    condition = '!el.value.length';
                    message = 'поле не должно быть пустым';
                    break;
                case 'contract_name':
                    condition = '!el.value.length';
                    message = 'поле не должно быть пустым';
                    break;
                case 'accept_act_at':
                    condition = '!el.value.length';
                    message = 'поле не должно быть пустым';
                    break;
                case 'contract_created_at':
                    condition = '!el.value.length';
                    message = 'поле не должно быть пустым';
                    break;
                case 'transfer_act_at':
                    condition = '!el.value.length';
                    message = 'поле не должно быть пустым';
                    break;
                case 'rent_at':
                    condition = '!el.value.length';
                    message = 'поле не должно быть пустым';
                    break;
                case 'area':
                    condition = '!el.value.length';
                    message = 'поле не должно быть пустым';
                    break;
                case 'rent':
                    condition = '!el.value.length';
                    message = 'поле не должно быть пустым';
                    break;
                case 'deposit':
                    condition = '!el.value.length';
                    message = 'поле не должно быть пустым';
                    break;
            }
            this.validate(el, condition, message);
            this.setDataParam(el);
        });
    }

    handle() {
        this.addButtonElem.addEventListener('click', () => {
            event.preventDefault();
            this.resetShowedErrors();
            this.parse();

            if (!this.errorInputNames.length) {
                this.submit();
            }
        });
    }

    // функция проверки условия для валидации
    validate(el, condition, message) {
        if (eval(condition)) {
            this.showError(el, message);
        }
    }

    resetShowedErrors() {
        this.errorInputNames = [];
        this.inputElems.forEach(el => {
            el.classList.remove('error_input');
        });
    }

    showError(el, message) {
        this.errorInputNames.push(el.name);
        el.classList.add('error_input');
        el.title = message;
    }

    submit() {
        let textHTML = '';
        for (let key in this.data) {
            textHTML += `<input type="hidden" name="${key}" value="${this.data[key]}">`;
        }
        this.sendFormElem.insertAdjacentHTML('beforeend', textHTML);
        this.sendFormElem.submit();
    }
}

const addTenant = new AddTenant();