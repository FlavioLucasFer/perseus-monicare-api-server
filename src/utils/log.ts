import { greenBright, redBright, yellowBright } from 'chalk';

function successLog(str: string) : void {
	console.log(greenBright(str));
}

function errorLog(str: string) : void {
	console.log(redBright(str));
}

function warningLog(str: string) : void {
	console.log(yellowBright(str));	
}

export {
	successLog,
	errorLog,
	warningLog,
};
