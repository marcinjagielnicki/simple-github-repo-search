import React, {Component, useState} from "react";
import PropTypes from 'prop-types';

function Form(props) {
    const [searchObj, setValues] = useState({
        name: '',
        sortBy: 'name'
    });
    const {onSearch} = props;

    const handleChange = (prop) => (event) => {
        setValues({ ...searchObj, [prop]: event.target.value });
    };
    return (
        <form className="w-full max-w-4xl mx-auto my-4">
            <div className="flex flex-wrap w-full justify-between justify-center">
                <div className="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                    <label className="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                           htmlFor="grid-first-name">
                        Repostory name
                    </label>
                    <input onChange={handleChange('name')}
                        className="appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                        id="grid-first-name" type="text" placeholder="symfony/console or sensiolabs"/>

                </div>
                <div className="w-full md:w-1/4 px-3 mb-6 md:mb-0">
                    <label className="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                           htmlFor="grid-state">
                        Sort by
                    </label>
                    <div className="relative">
                        <select onChange={handleChange('sortBy')}
                            className="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                            id="grid-state">
                            <option value={'name'}>Best match</option>
                            <option value={'fork'}>Number of forks</option>
                        </select>
                        <div
                            className="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <svg className="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                 viewBox="0 0 20 20">
                                <path
                                    d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                            </svg>
                        </div>
                    </div>
                </div>
                <div className="w-full md:w-1/4 px-3 mb-6 md:mb-0 items-center flex mt-3">
                    <button onClick={() => onSearch(searchObj)}
                        className="shadow bg-purple-500 hover:bg-purple-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded align-middle flex"
                        type="button">
                        Search
                    </button>
                </div>
            </div>
        </form>
    )

}
Form.propTypes = {
  onSearch: PropTypes.func
};

export default Form;