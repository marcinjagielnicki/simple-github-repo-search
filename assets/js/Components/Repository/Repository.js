import React from "react"
import propTypes from "prop-types"
import _ from "lodash"

function Repository(props) {
    const {item} = props;
    const renderLanguage = (language) => {
        return (
            <span key={language.name}
                  className="inline-block bg-gray-200 rounded-full px-3 py-1 my-1 mx-1 text-sm font-semibold text-gray-700 mr-2">{language.name}</span>
        )
    };

    const renderFork = (fork) => {
        return (
            <a href={fork.url} target="_blank">
                 <span key={fork.name}
                       className="inline-block bg-gray-200 rounded-full px-3 py-1 my-1 mx-1 text-sm font-semibold text-gray-700 mr-2">{fork.fullName}</span>
            </a>
        )
    };


    return (
        <div className="rounded overflow-hidden shadow-lg bg-white">
            <div className="px-6 py-4">
                <div className="font-bold text-xl mb-3">
                    <a className="text-indigo-500 hover:underline" target="_blank" href={item.url}>{item.fullName}</a>
                </div>
                {item.forkOf !== null ? (
                    <div className="font-bold text-l mb-3">
                        Fork of {renderFork(item.forkOf)}
                    </div>
                ) : null}
                {item.forks.length > 0 ? (
                    <>
                        <div className="font-bold text-l mb-1">Forks:</div>
                        <div className="">
                            <ul>
                                {
                                    _.slice(item.forks, 0, 9).map((fork) => renderFork(fork))
                                }
                            </ul>
                        </div>
                        {
                            item.forks.length > 10 ?
                                <div className="font-italic">And {item.forks.length - 10} more...</div> : null
                        }
                    </>
                ) : null}

            </div>
            {item.languages.length > 0 ? (
                <>
                    <div className="font-bold text-l mb-1 px-6">Used languages:</div>
                    <div className="px-6 py-4">
                        {
                            item.languages.map((language) => renderLanguage(language))
                        }
                    </div>
                </>
            ) : null}
        </div>
    );
}

Repository.propTypes = {
    item: propTypes.object
};

export default Repository;
