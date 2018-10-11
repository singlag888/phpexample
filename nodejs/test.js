const fs = require('fs');

const readFile = function (fileName) {
    return new Promise(function (resolve, reject) {
        fs.readFile(fileName, function (error, data) {
            // console.log(fileName);
            // console.log(data);
            if (error) return reject(error);
            resolve(data);
        })
    });
};

const asyncReadFile = async function () {
    const f1 = await readFile('helloworld.js');
    const f2 = await readFile('http.js');
    console.log(f1.toString());
    console.log(f2.toString());
};

asyncReadFile();

/*const gen = function* () {
    const f1 = yield readFile('helloworld.js');
    const f2 = yield readFile('http.js');
    console.log(f1);
    console.log(f2);
};


let gen1 = gen();
gen1.next();
gen1.next();
gen1.next();
gen1.next();*/

// let next = gen1.next();
// log(next);
// next.value.then(function (value) {
//     console.log(value);
// });
// gen1.next().value.then(function (value) {
//     console.log(value);
// });
// console.log(gen1.next());
// console.log(gen1.next());
