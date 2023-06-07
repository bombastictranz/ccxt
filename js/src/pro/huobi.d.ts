import huobiRest from '../huobi.js';
import { Int } from '../base/types.js';
import Client from '../base/ws/Client.js';
export default class huobi extends huobiRest {
    describe(): any;
    requestId(): any;
    watchTicker(symbol: string, params?: {}): Promise<any>;
    handleTicker(client: Client, message: any): any;
    watchTrades(symbol: string, since?: Int, limit?: Int, params?: {}): Promise<any>;
    handleTrades(client: Client, message: any): any;
    watchOHLCV(symbol: string, timeframe?: string, since?: Int, limit?: Int, params?: {}): Promise<any>;
    handleOHLCV(client: Client, message: any): void;
    watchOrderBook(symbol: string, limit?: Int, params?: {}): Promise<any>;
    handleOrderBookSnapshot(client: Client, message: any, subscription: any): void;
    watchOrderBookSnapshot(client: any, message: any, subscription: any): Promise<any>;
    handleDelta(bookside: any, delta: any): void;
    handleDeltas(bookside: any, deltas: any): void;
    handleOrderBookMessage(client: Client, message: any, orderbook: any): any;
    handleOrderBook(client: Client, message: any): void;
    handleOrderBookSubscription(client: Client, message: any, subscription: any): void;
    watchMyTrades(symbol?: string, since?: Int, limit?: Int, params?: {}): Promise<any>;
    getOrderChannelAndMessageHash(type: any, subType: any, market?: any, params?: {}): any[];
    watchOrders(symbol?: string, since?: Int, limit?: Int, params?: {}): Promise<any>;
    handleOrder(client: Client, message: any): void;
    parseWsOrder(order: any, market?: any): import("../base/types.js").Order;
    parseOrderTrade(trade: any, market?: any): import("../base/types.js").Trade;
    watchBalance(params?: {}): Promise<any>;
    handleBalance(client: Client, message: any): void;
    handleSubscriptionStatus(client: Client, message: any): any;
    handleSystemStatus(client: Client, message: any): any;
    handleSubject(client: Client, message: any): any;
    pong(client: any, message: any): Promise<void>;
    handlePing(client: Client, message: any): void;
    handleAuthenticate(client: Client, message: any): any;
    handleErrorMessage(client: Client, message: any): any;
    handleMessage(client: Client, message: any): void;
    handleMyTrade(client: Client, message: any, extendParams?: {}): void;
    parseWsTrade(trade: any): import("../base/types.js").Trade;
    getUrlByMarketType(type: any, isLinear?: boolean, isPrivate?: boolean): any;
    subscribePublic(url: any, symbol: any, messageHash: any, method?: any, params?: {}): Promise<any>;
    subscribePrivate(channel: any, messageHash: any, type: any, subtype: any, params?: {}, subscriptionParams?: {}): Promise<any>;
    authenticate(params?: {}): Promise<any>;
}
