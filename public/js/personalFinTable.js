class PersonalFinTable {
    constructor() {
        this.init();
        this.handle();
    }

    init() {
        this.tenantsLinkElem = document.getElementById('tenants_link');
        this.formElem = document.getElementById('tenant_info');
    }

    handle() {
        this.tenantsLinkElem.addEventListener('click', () => {
            this.formElem.submit();
        });
    }
}

const personalFinTable = new PersonalFinTable();