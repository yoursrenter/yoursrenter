class FinancialTable {
    constructor() {
        this.init();
        this.handle();
    }

    init() {
        this.data = [];
        this.addFormElem = document.getElementById('addFinanceForm');
        this.addButtonElem = this.addFormElem.querySelector('input[type="submit"]');
        this.lineElems = document.querySelectorAll('.financial__line');
        this.financeFormElem = document.getElementById('financial_form');
    }

    parse(elem) {
        const childs = elem.children;
        for (let i = 0; i < childs.length; i++) {
            this.data[childs[i].name] = childs[i].value;
        }
        this.data['finance_line_id'] = elem.id;
    }

    handle() {
        this.addButtonElem.addEventListener('click', () => {
            event.preventDefault();
            this.addFormElem.submit();
        });

        this.lineElems.forEach(elem => {
            elem.addEventListener('dblclick', () => {
                this.parse(elem);
                this.financeFormElem.submit();
            });
        });
    }
}

const financialTable = new FinancialTable();