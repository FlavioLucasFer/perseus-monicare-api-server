function successResponse(status: number, message: string, data: Array<object> | object) : object {
	return {
		status,
		result: {
			message,
			data,
		},
	};
}

function errorResponse(status: number, message: string, error: string | object) : object {
	console.log(error);

	return {
		status,
		result: {
			message,
			error,
		},
	};
};

export {
	successResponse,
	errorResponse,
};