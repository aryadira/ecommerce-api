import axios from "axios";
import { useState } from "react";
import { Link } from "react-router-dom";

const Create = () => {
  const baseUrl = "http://127.0.0.1:8000/api/a1";

  const [username, setUsername] = useState("");
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");

  const fetchAPI = async (e) => {
    e.preventDefault();

    try {
      const api = await axios.post(`${baseUrl}/users`, {
        username,
        email,
        password,
      });
      return api;
    } catch (e) {
      console.log(e.message);
    }
  };

  return (
    <div className='flex justify-center bg-slate-50 min-h-screen '>
      <div className='container'>
        <div className='header flex items-center my-10'>
          <Link
            to='/'
            className='py-2.5 px-5 me-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:border-gray-600'>
            Back
          </Link>
          <h1 className='text-2xl font-bold'>Create user</h1>
        </div>
        <form className='max-w-sm mx-auto'>
          <div className='mb-5'>
            <label htmlFor='email' className='block mb-2 text-sm font-medium text-gray-900'>
              Username
            </label>
            <input
              onChange={(e) => setUsername(e.target.value)}
              type='text'
              id='username'
              className='bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:border-gray-600 dark:focus:ring-blue-500 dark:focus:border-blue-500'
              placeholder='username'
              required
            />
            <label htmlFor='email' className='block mb-2 text-sm font-medium text-gray-900'>
              Your email
            </label>
            <input
              onChange={(e) => setEmail(e.target.value)}
              type='email'
              id='email'
              className='bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:border-gray-600 dark:focus:ring-blue-500 dark:focus:border-blue-500'
              placeholder='name@flowbite.com'
              required
            />
          </div>
          <div className='mb-5'>
            <label htmlFor='password' className='block mb-2 text-sm font-medium text-gray-900'>
              Your password
            </label>
            <input
              onChange={(e) => setPassword(e.target.value)}
              type='password'
              id='password'
              placeholder='password'
              className='bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-600 dark:focus:ring-blue-500 dark:focus:border-blue-500'
              required
            />
          </div>

          <button
            onClick={(e) => fetchAPI(e)}
            type='submit'
            className='text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800'>
            Create
          </button>
        </form>
      </div>
    </div>
  );
};

export default Create;
