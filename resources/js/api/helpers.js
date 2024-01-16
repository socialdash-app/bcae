export function convertHex(hexCode, opacity = 1) {
    if (!hexCode) return hexCode;
    let hex = hexCode.replace('#', '');

    if (hex.length === 3) {
        hex = hex[0] + hex[0] + hex[1] + hex[1] + hex[2] + hex[2];
    }

    let r = parseInt(hex.substring(0, 2), 16),
        g = parseInt(hex.substring(2, 4), 16),
        b = parseInt(hex.substring(4, 6), 16);

    /* Backward compatibility for whole number based opacity values. */
    if (opacity > 1 && opacity <= 100) {
        opacity = opacity / 100;
    }

    return 'rgba(' + r + ',' + g + ',' + b + ',' + opacity + ')';
}

export function separateWordByDash(string) {
    let split = string.split(' ');
    let final = '';
    split.forEach((v, index) => {
        // final += v.substring(0, 1).toUpperCase() + v.substring(1, v.length);
        final += v.toLowerCase();
        if (index !== split.length - 1) {
            final += '-';
        }
    })
    return final;
}


export function placeElementRelativeToScreen(element, shouldCenter = false) {
    return new Promise((resolve) => {
        // Get bounding rect of element
        let screenWidth = window.innerWidth;
        let screenHeight = window.innerHeight;
        let boundingRect = element.getBoundingClientRect();
        let margin = {
            top: 0,
            left: shouldCenter ? -boundingRect.width / 2 : 0,
        }

        if (boundingRect.left + boundingRect.width >= screenWidth) {
            margin.left -= boundingRect.left + boundingRect.width - screenWidth;
        }

        // Check if bottom offset of element is below screen.
        if (boundingRect.top + boundingRect.height >= screenHeight) {
            // compute distance between bottom and screen height
            margin.top -= boundingRect.top + boundingRect.height - screenHeight;
        }

        element.style.marginTop = margin.top + 'px';
        element.style.marginLeft = margin.left + 'px';

        resolve(element)
    });
}
