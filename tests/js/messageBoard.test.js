const MessageBoard = require('../../src/messageBoard');

test('create and post message', () => {
    const messageBoard = new MessageBoard();
    expect(messageBoard.createRoom('general')).toBe(true);
    expect(messageBoard.createUser('Alice')).toBe(true);
    expect(messageBoard.postMessage('Alice', 'general', 'Hello')).toBe(true);
    expect(messageBoard.getMessages('general')).toEqual([
        {user: 'Alice', content: 'Hello'}
    ]);
});