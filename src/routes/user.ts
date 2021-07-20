import { Router } from 'express';

import User from '../domain/entities/User';
import UserService from '../domain/services/UserService';
import { SUCCESS_STATUS, ERROR_STATUS } from '../utils/responseStatus';
import { errorResponse, successResponse } from '../utils/serverResponse';

const userService = new UserService();

const USER_ROUTES = {
	login: '/login',
	add: '/add',
	edit: '/edit',
	remove: '/remove',
	find: '/find',
	findAll: '/find-all',
	findById: '/find-by-id',
	findOne: '/find-one'
};

const router = Router();

router.post(USER_ROUTES.add, async (req, res) => {
	const {
		name,
		age,
		federalDocument,
		password,
	} = req.body;

	try {
		const insertedId = await userService.save(new User({
			name,
			age,
			federalDocument,
			password,
		}));

		res.send(successResponse(SUCCESS_STATUS.created, 'User successfully saved!', {insertedId}));
	} catch (err) {
		res.send(errorResponse(ERROR_STATUS.badRequest, 'Some error occurred when saving user.', err.message));
	}
});

router.post(USER_ROUTES.edit, async (req, res) => {
	const {
		id,
		name,
		age,
		federalDocument,
		password,
		type,
	} = req.body;

	if (!id) {
		const errorMessage = 'Id is required for edit an user.';
		res.send(errorResponse(ERROR_STATUS.badRequest, errorMessage, errorMessage)); 
	}

	try {
		await userService.save(new User({
			id,
			name,
			age,
			federalDocument,
			password,
			type,
		}));

		res.send(successResponse(SUCCESS_STATUS.ok, 'User successfully edited!', {}));
	} catch (err) {
		res.send(errorResponse(ERROR_STATUS.badRequest, 'Some error occurred when editing user.', err));
	}
});

router.post(USER_ROUTES.remove, async (req, res) => {
	const { id } = req.body;

	try {
		await userService.remove(id);
		res.send(successResponse(SUCCESS_STATUS.ok, 'User successfully removed!', {}));
	} catch (err) {
		res.send(errorResponse(ERROR_STATUS.badRequest, 'Some error occurred when removing user.', err));
	}
});

router.post(USER_ROUTES.find, async (req, res) => {
	const { where } = req.body;

	try {
		const users = await userService.find(where);

		res.send(successResponse(SUCCESS_STATUS.ok, 'Users successfully found!', users));
	} catch (err) {
		res.send(errorResponse(ERROR_STATUS.badRequest, 'Some error occurred when finding users.', err));
	}
});

router.post(USER_ROUTES.findAll, async (req, res) => {
	const { where } = req.body;

	try {
		const users = await userService.findAll(where);

		res.send(successResponse(SUCCESS_STATUS.ok, 'Users successfully found!', users));
	} catch (err) {
		res.send(errorResponse(ERROR_STATUS.badRequest, 'Some error occurred when finding users.', err));
	}
});

router.post(USER_ROUTES.findById, async (req, res) => {
	const { id } = req.body;

	if (!id) {
		const errorMessage = 'Id is required for find user by id.';
		res.send(errorResponse(ERROR_STATUS.badRequest, errorMessage, errorMessage));
	}

	try {
		const user = await userService.findById(id);
		res.send(successResponse(SUCCESS_STATUS.ok, 'User successfully found!', user));
	} catch (err) {
		res.send(errorResponse(ERROR_STATUS.badRequest, 'Some error occurred when finding user', err));
	}
});

router.post(USER_ROUTES.findOne, async (req, res) => {
	const { where } = req.body;

	if (!where) {
		const errorMessage = 'Where is required for find one specific user.';
		res.send(errorResponse(ERROR_STATUS.badRequest, errorMessage, errorMessage));
	}

	try {
		const user = await userService.findOne(where);
		res.send(successResponse(SUCCESS_STATUS.ok, 'User successfully found!', user));
	} catch (err) {
		res.send(errorResponse(ERROR_STATUS.badRequest, 'Some error occurred when finding user', err));
	}
});

export default router;
export {
	USER_ROUTES,
}
