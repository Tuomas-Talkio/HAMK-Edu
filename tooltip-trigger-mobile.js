const tooltipTrigger = document.querySelector('.gdpr');
const tooltip = document.querySelector('.tooltip');
tooltipTrigger.addEventListener('touchstart', function () {
    tooltip.classList.toggle('tooltip--visible');
});