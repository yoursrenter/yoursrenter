class TopMenu {
    constructor() {
        this.init();
        this.handle();
    }

    init() {
        this.exitButtonElem = document.getElementById('push_exit');
        this.settingsButtonElem = document.getElementById('push_settings');
        this.logoutElem = document.getElementById('logout');
        this.formTopMenuElem = document.getElementById('formTopMenu');

        this.tenantsButtonElem = document.getElementById('tenantsButton');
        this.financeButtonElem = document.getElementById('financeButton');
        this.headerButtonsElem = document.getElementById('header_buttons');
        this.mainTemplateElem = document.getElementById('mainTemplate');
        this.contentTemplateElem = document.getElementById('contentTemplate');
    }

    handle() {
        this.exitButtonElem.addEventListener('click', () => {
            event.preventDefault();
            this.logout();
        });
        this.settingsButtonElem.addEventListener('click', () => {
            event.preventDefault();
            this.showSettings();
        });
        this.financeButtonElem.addEventListener('click',()=>{
            event.preventDefault();
            this.mainTemplateElem.value = 'home';
            this.contentTemplateElem.value = 'financialTable';
            this.headerButtonsElem.submit();
        });
        this.tenantsButtonElem.addEventListener('click',()=>{
            event.preventDefault();
            this.mainTemplateElem.value = 'home';
            this.contentTemplateElem.value = 'listOfTenants';
            this.headerButtonsElem.submit();
        });
    }

    showSettings() {
        // function showSettings
    }

    logout() {
        this.logoutElem.value = 'logout';
        this.formTopMenuElem.submit();
    }
}

const topMenu = new TopMenu();

