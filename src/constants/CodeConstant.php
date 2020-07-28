<?php
/**
 * dashingUnique 拓展库
 * ==========================================================================
 * @link      http://erp.chaolizi.cn/
 * @license   http://erp.chaolizi.cn/license.html License
 * @Desc
 * ==========================================================================
 * @author    张大宝的程序人生 <1107842285@qq.com>
 */
declare(strict_types=1);

namespace dashingUnique\library\constants;


class CodeConstant
{
    const PRACK = 10000;                 //临时响应

    //成功处理的请求信息
    const SUCCESS = 20000;               //服务器已成功处理了请求
    const CREATED = 20001;               //请求成功并且服务器创建了新的资源
    const ACCEPTED = 20002;              //服务器已接受请求，但尚未处理
    const NON_AUTHORITATIVE_INFORMATION = 20003;     //服务器已成功处理了请求，但返回的信息可能来自另一来源。
    const NO_CONTENT = 20004;            //服务器成功处理了请求，但没有返回任何内容
    const RESET_CONTENT = 20005;         //响应状态通知客户端重置文档视图，例如清除表单内容，重置画布状态或刷新 UI。（重置内容）
    const PARTIAL_CONTENT = 20006;       //成功状态响应代码指示请求已成功并且主体包含所请求的数据范围(响应部分内容)

    //重定向
    const MULTIPLE_CHOICES = 30000;     //重定向状态响应代码指示该请求具有多个可能的响应。用户代理或用户应该选择其中的一个。由于没有选择其中一个响应的标准方式，因此此响应代码很少使用。
    const MOVED_PERMANENTLY = 30001;     //重定向状态响应代码指示所请求的资源已明确移动到Location标题给定的URL 。浏览器重定向到这个页面，搜索引擎更新它们到资源的链接（在 SEO 中，据说链接汁被发送到新的 URL）。
    const FOUND = 30002;                 //重定向状态响应代码指示所请求的资源已暂时移动到由Location标题给定的 URL 。浏览器重定向到这个页面，但是搜索引擎不会更新他们到资源的链接（在 SEO 中，据说链接果汁不会被发送到新的 URL）。
    const SEE_OTHER = 30003;             //重定向状态响应代码（通常作为一个 PUT或POST操作的结果发回）表示重定向不链接到新上载的资源，而是链接到其他页面，如确认页面或上载进度页面。用于显示此重定向页面的方法始终是GET。
    const NOT_MODIFIED = 30004;          //客户端重定向响应代码指示不需要重新传输请求的资源。这是对缓存资源的隐式重定向。这发生在请求方法是安全的时候，比如一个 GET或者一个HEAD请求，或者当请求是有条件的并且使用一个 If-None-Match或者一个If-Modified-Since标头时。
    const TEMPORARY_REDIRECT = 30007;    //重定向状态响应代码指示所请求的资源已暂时移动到由Location标题给定的 URL 。
    const PERMANENT_REDIRECT = 30008;    //重定向状态响应代码指示所请求的资源已明确移动到Location标题给定的 URL 。浏览器重定向到这个页面，搜索引擎更新它们到资源的链接（在 SEO 中，据说链接汁被发送到新的 URL）。

    //错误请求
    const BAD_REQUEST = 40000;           // 响应状态码指示服务器无法理解请求。客户不应未经修改就重复此请求。
    const UNAUTHORIZED = 40001;          //客户端错误状态响应代码指示该请求尚未应用，因为它缺少目标资源的有效认证凭证。
    const FORBIDDEN = 40003;             //客户端错误状态响应代码指示服务器理解请求但拒绝授权。
    const NOT_FOUND = 40004;             //客户端错误响应代码指示服务器找不到请求的资源。导致404页面的链接通常被称为断开或死链接，并且可能受到链接形势变化的影响。
    const METHOD_NOT_ALLOWED = 40005;    //响应状态码指示服务器已知请求方法，但已被禁用且无法使用。这两个强制性方法
    const NOT_ACCEPTABLE = 40006;        //客户端错误响应代码指示与在其中定义Accept-Charset和Accept-Language不能提供的可接受值列表匹配的响应。
    const PROXY_AUTHENTICATION_REQUIRED = 40007; //客户端错误状态响应代码指示该请求尚未应用，因为它缺少浏览器和可访问所请求资源的服务器之间的代理服务器的有效认证凭证。
    const REQUEST_TIMEOUT = 40008;       //响应状态码意味着服务器想要关闭这个未使用的连接。它由一些服务器在空闲连接上发送，即使客户端没有任何先前的请求。
    const CONFLICT = 40009;              //响应状态码指示与服务器当前状态的请求冲突。
    const GONE = 40010;                  //客户端错误响应代码指示对源服务器不再可用对目标资源的访问，并且此情况可能是永久性的。
    const LENGTH_REQUIRED = 40011;       //客户端错误响应代码指示服务器在没有定义的Content-Length头部的情况下拒绝接受请求。
    const PRECONDITION_FAILED = 40012;   //客户端错误响应代码指示对目标资源的访问已被拒绝。这种情况与上比其他方法条件请求GET或者HEAD当被定义的条件If-Unmodified-Since或If-None-Match头部不被满足。在这种情况下，无法进行请求（通常是上载或修改资源），并且发送此错误响应。
    const PAYLOAD_TOO_LARGE = 40013;     //响应状态码指示请求实体大于服务器定义的限制; 服务器可能会关闭连接或返回一个Retry-After标题字段。
    const URI_TOO_LONG = 40014;          //响应状态码指示客户端请求的 URI 比服务器愿意解释的更长。
    const UNSUPPORTED_MEDIA_TYPE = 40015;    //客户端错误响应代码指示服务器拒绝接受请求，因为有效内容格式的格式不受支持。
    const RANGE_NOT_SATISFIABLE = 40016; //错误响应代码指示服务器无法提供请求的范围。最可能的原因是文档不包含这样的范围，或者Range标题值虽然在语法上是正确的，但是没有意义。
    const EXPECTATION_FAILED = 40017;    //HTTP 417 Expectation Failed客户端错误响应代码指示Expect无法满足请求标头中给出的期望值。
    const UPGRADE_REQUIRED = 40026;      //客户端错误响应代码指示服务器拒绝使用当前协议执行请求，但可能在客户端升级到其他协议后愿意这样做。
    const PRECONDITION_REQUIRED = 40028; //HTTP 428 Precondition Required响应状态码指示服务器要求有条件的请求。
    const TOO_MANY_REQUESTS = 40029;     //响应状态码指示用户在给定时间内发送了太多请求（“限速”）。
    const REQUEST_HEADER_FIELDS_TOO_LARGE = 40031;   //响应状态码指示服务器不愿意处理请求，因为它的头部字段太大。请求可以在减少请求头域的大小后重新提交。
    const UNAVAILABLE_FOR_LEGAL_REASONS = 40051;     //客户端错误响应代码指示用户请求由于法律原因而不可用的资源，例如已发出法律行为的网页。

    //服务器内部错误
    const ERROR = 50000;                //服务器错误响应代码指示服务器遇到阻止它履行请求的意外情况。
    const NOT_IMPLEMENTED = 50001;      //服务器错误响应代码指示请求方法不受服务器支持并且无法处理。服务器需要支持的唯一方法（因此不能返回此代码）是GET和HEAD。
    const BAD_GATEWAY = 50002;          //服务器错误响应代码指示服务器充当网关或代理时收到来自上游服务器的无效响应。
    const SERVICE_UNAVAILABLE = 50003;  //服务器错误响应代码指示服务器尚未准备好处理请求。
    const GATEWAY_TIMEOUT = 50004;      //服务器错误响应代码指示服务器充当网关或代理时无法及时得到响应。
    const HTTP_VERSION_NOT_SUPPORTED = 50005;        //响应状态码指示服务器不支持请求中使用的 HTTP 版本。
    const NETWORK_AUTHENTICATION_REQUIRED = 50011;   //响应状态码指示客户端需要进行身份验证才能获得网络访问权限。

}