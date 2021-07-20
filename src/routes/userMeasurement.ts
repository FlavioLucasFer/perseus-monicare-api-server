import { Router } from 'express';

import UserMeasurement from '../domain/entities/UserMeasurement';
import UserMeasurementService from '../domain/services/UserMeasurementService';
import { ERROR_STATUS, SUCCESS_STATUS } from '../utils/responseStatus';
import { errorResponse, successResponse } from '../utils/serverResponse';

const userMeasurementService = new UserMeasurementService();

const USER_MEASUREMENT_ROUTES = {
	add: '/add',
	remove: '/remove',
	findAll: '/find-all',
	findById: '/find-by-id',
	findOne: '/find-one',
};

const router = Router();

router.post(USER_MEASUREMENT_ROUTES.add, async (req, res) => {
	const { 
		userId,
		bodyTemperature,
		bloodOxygenation,
		heartRate,
		measuredAt,  
	} = req.body;

	try {
		const insertedId = await userMeasurementService.save(userId, new UserMeasurement({
			bodyTemperature,
			bloodOxygenation,
			heartRate,
			measuredAt,
		}));

		res.status(SUCCESS_STATUS.created)
			.send(successResponse(SUCCESS_STATUS.created, 'User measurement successfully saved!', {insertedId}));
	} catch (err) {
		res.status(ERROR_STATUS.badRequest)
			.send(errorResponse(ERROR_STATUS.badRequest, 'Some error occurred when saving user measurement.', err.message));
	}
});

router.post(USER_MEASUREMENT_ROUTES.remove, async (req, res) => {
	const { userId, id } = req.body;

	try {
		await userMeasurementService.remove(userId, id);

		res.status(SUCCESS_STATUS.ok)
			.send(successResponse(SUCCESS_STATUS.ok, 'User measurement successfully removed!', {}));
	} catch (err) {
		res.status(ERROR_STATUS.badRequest)
			.send(errorResponse(ERROR_STATUS.badRequest, 'Some error occurred when removing user measurement.', err.message));
	}
});

router.post(USER_MEASUREMENT_ROUTES.findAll, async (req, res) => {
	const { userId, where } = req.body;

	try {
		const userMeasurements = await userMeasurementService.findAll(userId, where);

		res.status(SUCCESS_STATUS.ok)
			.send(successResponse(SUCCESS_STATUS.ok, 'User measurements found!', userMeasurements));
	} catch (err) {
		res.status(ERROR_STATUS.badRequest)
			.send(errorResponse(ERROR_STATUS.badRequest, 'Some error occurred when finding user measurements.', err.message));
	}
});

router.post(USER_MEASUREMENT_ROUTES.findById, async (req, res) => {
	const { userId, id } = req.body;

	try {
		const userMeasurement = await userMeasurementService.findById(userId, id);

		res.status(SUCCESS_STATUS.ok)
			.send(successResponse(SUCCESS_STATUS.ok, 'User measurement found!', userMeasurement));
	} catch (err) {
		res.status(ERROR_STATUS.badRequest)
			.send(errorResponse(ERROR_STATUS.badRequest, 'Some error occurred when finding user measurement.', err.message));
	}
});

router.post(USER_MEASUREMENT_ROUTES.findOne, async (req, res) => {
	const { userId, where } = req.body;

	try {
		const userMeasurement = await userMeasurementService.findOne(userId, where);

		res.status(SUCCESS_STATUS.ok)
			.send(successResponse(SUCCESS_STATUS.ok, 'User measurement found!', userMeasurement));
	} catch (err) {
		res.status(ERROR_STATUS.badRequest)
			.send(errorResponse(ERROR_STATUS.badRequest, 'Some error occurred when finding user measurement.', err.message));
	}
});

export default router;
export {
	USER_MEASUREMENT_ROUTES,
}
