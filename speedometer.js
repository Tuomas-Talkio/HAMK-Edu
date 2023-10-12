document.addEventListener("DOMContentLoaded", function () {
    let f = new FontFace("Poppins", "url(https://fonts.googleapis.com/css2?family=Poppins:wght@300)");

    f.load().then((font) => {
        // Font is loaded and ready to use
        document.fonts.add(font);
    }).catch((error) => {
        console.error('Font loading failed:', error);
    });
    // Function to map a value from the original range to the angle range
    function mapValueToAngle(value, minValue, maxValue, startAngle, endAngle) {
        return (
            ((value - minValue) / (maxValue - minValue)) * (endAngle - startAngle) + startAngle
        );
    }

    // Function to draw the speedometer on a canvas
    function drawSpeedometer(canvas, groupAverage, userAverage, minValue, maxValue) {
        const ctx = canvas.getContext("2d");
        ctx.imageSmoothingEnabled = false; // Disable anti-aliasing

        const centerX = canvas.width / 2;
        const centerY = canvas.height / 2;
        const radius = 100;
        const startAngle = -Math.PI; // Starting angle is -π
        const endAngle = 0; // Ending angle is 0


        let userAngle = mapValueToAngle(userAverage, minValue, maxValue, startAngle, endAngle);
        let groupAngle = mapValueToAngle(groupAverage, minValue, maxValue, startAngle, endAngle);

        // Clear canvas
        ctx.clearRect(0, 0, canvas.width, canvas.height);


        const color1 = 'red';
        const color2 = 'orange';
        const color3 = 'green';
        const color4 = 'blue';

        const gradient = ctx.createLinearGradient(0, 0, canvas.width, 0);

        gradient.addColorStop(0.125, color1); // Starting color
        gradient.addColorStop(0.375, color2); // Middle color
        gradient.addColorStop(0.625, color3); // Middle color
        gradient.addColorStop(0.875, color4); // Ending color

        ctx.beginPath();
        ctx.arc(centerX, centerY, radius - 5, startAngle, endAngle);
        ctx.lineWidth = 10;
        ctx.strokeStyle = gradient;
        ctx.stroke();


        // Draw speedometer scale markings
        ctx.beginPath();
        for (let i = minValue; i <= maxValue; i += 1) {
            let angle = mapValueToAngle(i, minValue, maxValue, startAngle, endAngle);
            let x0 = centerX + (radius - 10) * Math.cos(angle);
            let y0 = centerY + (radius - 10) * Math.sin(angle);
            let x1 = centerX + (radius - 20) * Math.cos(angle);
            let y1 = centerY + (radius - 20) * Math.sin(angle);

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

        // Draw group average pointer
        let fullAngle = Math.PI + groupAngle;
        let x0 = centerX + (radius + 5) * Math.cos(groupAngle);
        let y0 = centerY + (radius + 5) * Math.sin(groupAngle);
        let x1 = x0 - 20;
        let y1 = y0 - 15;
        let x2 = x1;
        let y2 = y0 + 15;
        let vertexA = {x: x0, y: y0};
        let vertexB = {x: x1, y: y1};
        let vertexC = {x: x2, y: y2};

        let pivot = vertexA;

        let rotatedVertexB = {
            x: pivot.x + (vertexB.x - pivot.x) * Math.cos(fullAngle) - (vertexB.y - pivot.y) * Math.sin(fullAngle),
            y: pivot.y + (vertexB.x - pivot.x) * Math.sin(fullAngle) + (vertexB.y - pivot.y) * Math.cos(fullAngle)
        }

        let rotatedVertexC = {
            x: pivot.x + (vertexC.x - pivot.x) * Math.cos(fullAngle) - (vertexC.y - pivot.y) * Math.sin(fullAngle),
            y: pivot.y + (vertexC.x - pivot.x) * Math.sin(fullAngle) + (vertexC.y - pivot.y) * Math.cos(fullAngle)
        }

        ctx.strokeStyle = "#000";
        ctx.lineWidth = 2;
        ctx.fillStyle = gradient;

        ctx.beginPath();
        ctx.moveTo(pivot.x, pivot.y);
        ctx.lineTo(rotatedVertexB.x, rotatedVertexB.y);
        ctx.lineTo(rotatedVertexC.x, rotatedVertexC.y);
        ctx.closePath();
        ctx.fill();
        ctx.stroke();

        let needleLength = radius - 20;
        // let x0 = centerX + (needleLength - 40)  * Math.cos(groupAngle);
        // let y0 = centerY + (needleLength - 40) * Math.sin(groupAngle);
        // let x1 = centerX + needleLength * Math.cos(groupAngle);
        // let y1 = centerY + needleLength * Math.sin(groupAngle);
        // ctx.beginPath();
        // ctx.moveTo(x0, y0);
        // ctx.lineTo(x1, y1);
        // ctx.lineWidth = 20;
        // ctx.strokeStyle = "#ffa500";
        // ctx.stroke();

        // Draw speedometer needle
        x0 = centerX + (needleLength - 30)  * Math.cos(userAngle);
        y0 = centerY + (needleLength - 30) * Math.sin(userAngle);
        x1 = centerX + needleLength * Math.cos(userAngle);
        y1 = centerY + needleLength * Math.sin(userAngle);
        ctx.beginPath();
        ctx.moveTo(x0, y0);
        ctx.lineTo(x1, y1);
        ctx.lineWidth = 4;
        ctx.strokeStyle = "#000";
        ctx.lineCap = "butt";
        ctx.stroke();






        // Draw legend text
        const minTextX = centerX - radius + 5;
        const minTextY = centerY + 30;
        const maxTextX = centerX + radius - 5;
        const maxTextY = centerY + 30;
        const currentTextX = centerX;
        const currentTextY = centerY;
        const groupTextX = centerX + (radius + 30) * Math.cos(groupAngle);
        const groupTextY = centerY + (radius + 30) * Math.sin(groupAngle);

        ctx.font = "30px Poppins";
        ctx.textAlign = "center"
        ctx.fillStyle = "#000";
        ctx.fillText(`${minValue}`, minTextX, minTextY);
        ctx.fillText(`${maxValue}`, maxTextX, maxTextY);
        ctx.font = "40px Poppins";
        ctx.fillText(`${userAverage}`, currentTextX, currentTextY);

        ctx.save();
        ctx.translate(groupTextX, groupTextY);
        ctx.rotate(groupAngle + Math.PI / 2);
        ctx.font = "18px Poppins";

        ctx.fillText('Group', 0, 0);

        ctx.restore();
        ctx.translate(0.5, 0.5);
    }

    // Get all canvases
    const canvases = document.getElementsByClassName("speedometer-canvas");

    for (let i = 0; i < canvases.length; i++) {
        const canvas = canvases[i];
        console.log(canvas.dataset.user);
        const groupAverage = parseFloat(canvas.dataset.result);
        const userAverage = parseFloat(canvas.dataset.user);
        const minValue = 1;
        const maxValue = 5;
        drawSpeedometer(canvas, groupAverage, userAverage, minValue, maxValue);
    }
});