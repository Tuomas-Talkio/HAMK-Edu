document.addEventListener("DOMContentLoaded", function () {
    // Function to map a value from the original range to the angle range
    function mapValueToAngle(value, minValue, maxValue, startAngle, endAngle) {
        return (
            ((value - minValue) / (maxValue - minValue)) * (endAngle - startAngle) + startAngle
        );
    }

    // Function to draw the speedometer on a canvas
    function drawSpeedometer(canvas, speedValue, minValue, maxValue) {
        const ctx = canvas.getContext("2d");
        ctx.imageSmoothingEnabled = false; // Disable anti-aliasing

        const centerX = canvas.width / 2;
        const centerY = canvas.height / 2;
        const radius = 100;
        const startAngle = -Math.PI; // Starting angle is -π
        const endAngle = 0; // Ending angle is 0

        let currentAngle = mapValueToAngle(speedValue, minValue, maxValue, startAngle, endAngle);

        // Clear canvas
        ctx.clearRect(0, 0, canvas.width, canvas.height);

        // Draw speedometer scale markings
        ctx.beginPath();
        for (let i = minValue; i <= maxValue; i += 1) {
            let angle = mapValueToAngle(i, minValue, maxValue, startAngle, endAngle);
            let x0 = centerX + radius * Math.cos(angle);
            let y0 = centerY + radius * Math.sin(angle);
            let x1 = centerX + (radius - 10) * Math.cos(angle);
            let y1 = centerY + (radius - 10) * Math.sin(angle);

            ctx.moveTo(x0, y0);
            ctx.lineTo(x1, y1);
        }
        ctx.strokeStyle = "#000";
        ctx.lineWidth = 2;
        ctx.stroke();

        ctx.beginPath();
        ctx.arc(centerX, centerY, radius, startAngle, endAngle);
        ctx.lineWidth = 3;
        ctx.strokeStyle = "#000";
        ctx.stroke();

        ctx.beginPath();
        ctx.arc(centerX, centerY, radius - 10, startAngle, endAngle);
        ctx.lineWidth = 3;
        ctx.strokeStyle = "#000";
        ctx.stroke();

        // Draw speedometer needle
        let needleLength = radius;
        let x1 = centerX + needleLength * Math.cos(currentAngle);
        let y1 = centerY + needleLength * Math.sin(currentAngle);
        ctx.beginPath();
        ctx.moveTo(centerX, centerY);
        ctx.lineTo(x1, y1);
        ctx.lineWidth = 4;
        ctx.strokeStyle = "#f00";
        ctx.stroke();

        ctx.beginPath();
        ctx.arc(centerX, centerY, 5, 0, 2 * Math.PI);
        ctx.fillStyle = "#f00"; // Red color
        ctx.fill();

        // Draw legend text
        const minTextX = centerX - radius - 5;
        const minTextY = centerY + 30;
        const maxTextX = centerX + radius - 5;
        const maxTextY = centerY + 30;
        const currentTextX = centerX - 40;
        const currentTextY = centerY + 30;

        ctx.font = "30px Helvetica";
        ctx.fillStyle = "#000";
        ctx.fillText(`${minValue}`, minTextX, minTextY);
        ctx.fillText(`${maxValue}`, maxTextX, maxTextY);
        ctx.fillText(`${speedValue}`, currentTextX, currentTextY);

        ctx.translate(0.5, 0.5);
    }

    // Get all canvases
    const canvases = document.getElementsByClassName("speedometer-canvas");

    for (let i = 0; i < canvases.length; i++) {
        const canvas = canvases[i];
        const speedValue = parseFloat(canvas.dataset.result);
        const minValue = 1;
        const maxValue = 5;
        drawSpeedometer(canvas, speedValue, minValue, maxValue);
    }
});