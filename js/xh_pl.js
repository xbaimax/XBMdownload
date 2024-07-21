(function() {
    "use strict";

    let stop;
    let staticx = true;

    class ImageLoader {
        constructor(src) {
            this.img = new Image();
            this.img.src = src;
            this.img.onload = this.onImageLoad.bind(this);
        }

        onImageLoad() {
            const image = this.getImage();
            startSnowflake(image);
        }

        getImage() {
            return this.img;
        }
    }

    class Snowflake {
        constructor(x, y, s, r, fn, img) {
            this.x = x;
            this.y = y;
            this.s = s;
            this.r = r;
            this.fn = fn;
            this.img = img;
        }

        draw(cxt) {
            cxt.save();
            const xc = 40 * this.s / 4;
            cxt.translate(this.x, this.y);
            cxt.rotate(this.r);
            cxt.drawImage(this.img, 0, 0, 40 * this.s, 40 * this.s);
            cxt.restore();
        }

        update() {
            this.x = this.fn.x(this.x, this.y);
            this.y = this.fn.y(this.y, this.y);
            this.r = this.fn.r(this.r);
            if (this.x > window.innerWidth || this.x < 0 || this.y > window.innerHeight || this.y < 0) {
                this.r = getRandom('fnr');
                if (Math.random() > 0.4) {
                    this.x = getRandom('x');
                    this.y = 0;
                    this.s = getRandom('s');
                    this.r = getRandom('r');
                } else {
                    this.x = window.innerWidth;
                    this.y = getRandom('y');
                    this.s = getRandom('s');
                    this.r = getRandom('r');
                }
            }
        }
    }

    class SnowflakeList {
        constructor() {
            this.list = [];
        }

        push(snowflake) {
            this.list.push(snowflake);
        }

        update() {
            for (let i = 0, len = this.list.length; i < len; i++) {
                this.list[i].update();
            }
        }

        draw(cxt) {
            for (let i = 0, len = this.list.length; i < len; i++) {
                this.list[i].draw(cxt);
            }
        }

        get(i) {
            return this.list[i];
        }

        size() {
            return this.list.length;
        }
    }

    function getRandom(option) {
        let ret, random;
        switch (option) {
            case 'x':
                ret = Math.random() * window.innerWidth;
                break;
            case 'y':
                ret = Math.random() * window.innerHeight;
                break;
            case 's':
                ret = Math.random();
                break;
            case 'r':
                ret = Math.random() * 6;
                break;
            case 'fnx':
                random = -0.5 + Math.random() * 1;
                ret = function(x, y) {
                    return x + 0.5 * random - 1.7;
                };
                break;
            case 'fny':
                random = 1.5 + Math.random() * 0.7;
                ret = function(x, y) {
                    return y + random;
                };
                break;
            case 'fnr':
                random = Math.random() * 0.03;
                ret = function(r) {
                    return r + random;
                };
                break;
            default:
                console.error("Unknown option for getRandom:", option);
                ret = null;
        }
        return ret;
    }

    function startSnowflake(image) {
        const canvas = document.createElement('canvas');
        const cxt = canvas.getContext('2d');
        staticx = true;
        canvas.height = window.innerHeight;
        canvas.width = window.innerWidth;
        canvas.setAttribute('style', 'position: fixed;left: 0;top: 0;pointer-events: none;');
        canvas.setAttribute('id', 'canvas_Snowflake');
        document.body.appendChild(canvas);

        const snowflakeList = new SnowflakeList();
        for (let i = 0; i < 50; i++) {
            const snowflake = new Snowflake(getRandom('x'), getRandom('y'), getRandom('s'), getRandom('r'), {
                x: getRandom('fnx'),
                y: getRandom('fny'),
                r: getRandom('fnr')
            }, image);
            snowflakeList.push(snowflake);
        }

        stop = window.requestAnimationFrame(function animate() {
            cxt.clearRect(0, 0, canvas.width, canvas.height);
            snowflakeList.update();
            snowflakeList.draw(cxt);
            stop = window.requestAnimationFrame(animate);
        });

        window.onresize = function() {
            const canvasSnow = document.getElementById('canvas_Snowflake');
            canvasSnow.width = window.innerWidth;
            canvasSnow.height = window.innerHeight;
        };
    }

    const imageLoader = new ImageLoader("https://s21.ax1x.com/2024/07/06/pkWmMOx.png");

    function stopp() {
        if (staticx) {
            const child = document.getElementById("canvas_Snowflake");
            child.parentNode.removeChild(child);
            window.cancelAnimationFrame(stop);
            staticx = false;
        } else {
            startSnowflake(imageLoader.getImage());
        }
    }
})();