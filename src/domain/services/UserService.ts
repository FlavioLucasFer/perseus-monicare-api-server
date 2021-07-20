import User from "../entities/User";
import UserDAO from "../../database/dao/UserDAO"
import { errorLog, successLog } from "../../utils/log";

class UserService {
	#userDAO = new UserDAO();

	async save(user: User) : Promise<number | string | void> {
		try {
			const insertedId = await this.#userDAO.save(user);
			
			successLog('[DATABASE] User successfully saved!');
			
			if (insertedId)
				return insertedId;
		} catch (err) {
			errorLog('[DATABASE] Some error occurred when saving user...');
			errorLog(`[DATABASE ERROR] ${err}`);
			
			throw new Error(err);
		}
	}

	async remove(id: number | string) : Promise<void> {
		try {
			await this.#userDAO.remove(id);
			successLog('[DATABASE] User successfully removed!');
		} catch (err) {
			errorLog('[DATABASE] Some error occurred when removing user...');
			errorLog(`[DATABASE ERROR] ${err}`);

			throw new Error(err);
		}
	}

	async find(where?: object) : Promise<Array<User>> {
		try {
			const users = await this.#userDAO.find(where);

			successLog('[DATABASE] Users successfully queried!');
			return users;
		} catch (err) {
			errorLog('[DATABASE] Some error occurred when querying for users');
			errorLog(`[DATABASE ERROR] ${err}`);

			throw new Error(err);
		}
	}

	async findAll(where?: object) : Promise<Array<User>> {
		try {
			const users = await this.#userDAO.findAll(where);

			successLog('[DATABASE] Users successfully queried!');
			return users;
		} catch (err) {
			errorLog('[DATABASE] Some error occurred when querying for users');
			errorLog(`[DATABASE ERROR] ${err}`);

			throw new Error(err);
		}
	}

	async findOne(where: object) : Promise<User> {
		try {
			const user = await this.#userDAO.findOne(where);

			successLog('[DATABASE] User successfully queried!');
			return user;
		} catch (err) {
			errorLog('[DATABASE] Some error occurred when querying for user');
			errorLog(`[DATABASE ERROR] ${err}`);

			throw new Error(err);
		}
	}

	async findById(id: number | string) : Promise<User> {
		try {
			const user = await this.#userDAO.findById(id);

			successLog('[DATABASE] User successfully queried!');
			return user;
		} catch (err) {
			errorLog('[DATABASE] Some error occurred when querying for user');
			errorLog(`[DATABASE ERROR] ${err}`);

			throw new Error(err);
		}
	}
}

export default UserService;