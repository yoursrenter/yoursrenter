/**
 * в этом файле: класс для отправки формы, класс DashBoard, класс для верхних кнопок
 */

/**
 * промужточный элемент, который и будет заниматься отправкой данных
 */
class FormDashboard {
    constructor(value) {
        this.form = document.getElementById('wrap_dashboard');
        if (this.form) {
            this.form.firstElementChild.value = value;
            this.submit();
        }
    }

    submit() {
        this.form.submit();
    }
}

/**
 * "считыватель" того, куда нажмет пользователь на Дашбоарде
 */
class DashBoard {
    constructor() {
        this.init();
        this.handle();
    }

    init() {
        this.dashBoardElem = document.querySelector('.wrap_dashboard');
        this.id = null;
        this.data = '';
    }

    handle() {
        this.dashBoardElem.addEventListener('click', () => {
            event.preventDefault();
            let target = event.target;
            if (target.className.includes('pointer')) {
                this.parse(target.id);
                this.submit();
            } else if (target.parentElement.className.includes('pointer')) {
                target = target.parentElement;
                this.parse(target.id);
                this.submit();
            }
        });
    }

    parse(id) {
        switch (id) {
            case 'wrap_grid_1p':
                this.data = 'areas';
                break;
            case 'wrap_grid_2p':
                this.data = 'price';
                break;
            case 'wrap_grid_3':
                this.data = 'button3';
                break;
            case 'wrap_grid_41__text':
                this.data = 'tenants';
                break;
            case 'wrap_grid_add':
                this.data = 'add_tenant';
                break;
            case 'wrap_grid_51':
                this.data = 'button5';
                break;
            case 'wrap_grid_52':
                this.data = 'button6';
                break;
            case 'wrap_grid_42':
                this.data = 'button7';
                break;
            case 'wrap_grid_53':
                this.data = 'button8';
                break;
            case 'wrap_grid_54':
                this.data = 'button9';
                break;
        }
    }

    submit() {
        const form = new FormDashboard(this.data);
    }

}

/**
 * верхнее меню
 */
class TopButtons {
    constructor() {
        this.init();
        this.handle();
    }

    init() {
        this.buttonElems = document.querySelectorAll('.wrap_button');
    }

    handle() {
        this.buttonElems.forEach(elem => {
            elem.addEventListener('click', () => {
                event.preventDefault();
                const form = new FormDashboard(elem.id);
            });
        });
    }
}


const dashBoard = new DashBoard();
const topButtons = new TopButtons();