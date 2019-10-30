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