// course-student-view.js

import $ from 'jquery';

let $seccion_activa = null;

export const removeBreadcrumb = async() => {};

export const CourseStudentView = () => {

    var firstCharge = true;

    addStickyMenu();

    const listToPreventDoubleTitle = ['enrol'];
    const currentUrl = window.location.href;
    listToPreventDoubleTitle.forEach(keyword => {
        if (currentUrl.includes(keyword)) {
            const secondaryText = document.querySelector('.text--secondary');
            secondaryText?.remove();
        }
    });
};